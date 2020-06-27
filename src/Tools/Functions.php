<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Tools;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use DataTables\Table\ConfigBundle;
use ReflectionClass;

/**
 * Class Functions
 * Created by allancarvalho in abril 17, 2020
 */
class Functions {

	/**
	 * Storage a instance of object.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * @var int
	 */
	private $getAssociationAttempt = 0;

	/**
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Tools\Functions
	 */
	public static function getInstance() {
		if (static::$instance === null) {
			static::$instance = new self();
		}

		return static::$instance;
	}

	/**
	 * Get first key of array.
	 *
	 * @param array $array
	 * @return int|string|null
	 */
	public function arrayKeyFirst(array $array) {
		reset($array);

		return key($array);
	}

	/**
	 * Get last key of array.
	 *
	 * @param array $array
	 * @return int|string|null
	 */
	public function arrayKeyLast(array $array) {
		end($array);

		return key($array);
	}

	/**
	 * @param string $classWithNameSpace
	 * @throws \ReflectionException
	 * @return string
	 */
	public function getClassAndVersionMd5(string $classWithNameSpace): string {
		$appClassMd5 = '';
		if (file_exists(APP . 'DataTables' . DS . 'AppDataTables.php')) {
			$appClassMd5 = $this->getClassMd5(Configure::read('App.namespace') . '\\DataTables\\AppDataTables');
		}
		$classMd5 = $this->getClassMd5($classWithNameSpace);
		$pluginCurrentHash = $this->getPluginCurrentCommit();

		return md5($appClassMd5 . $classMd5 . $pluginCurrentHash);
	}

	/**
	 * Return the class md5
	 *
	 * @param string $classWithNameSpace Class name with namespace.
	 * @throws \ReflectionException
	 * @return string Md5 string
	 */
	public function getClassMd5(string $classWithNameSpace): string {
		return md5_file((new ReflectionClass($classWithNameSpace))->getFileName());
	}

	/**
	 * Return DataTables plugin current commit hash.
	 *
	 * @return string
	 */
	public function getPluginCurrentCommit(): string {
		$subPath = 'composer' . DS . 'installed.json';
		$filePaths = [
			ROOT . DS . 'vendor' . DS,
			DATA_TABLES_ROOT . DS . '..' . DS . '..' . DS,
		];
		foreach ($filePaths as $filePath) {
			$filePath = $filePath . $subPath;
			if (is_file($filePath)) {
				$packages = json_decode(file_get_contents($filePath));
			} else {
				continue;
			}
			foreach ($packages as $package) {
				if ($package->name === 'wsssoftware/cakephp-datatables') {
					return $package->dist->reference;
				}
			}
		}

		return md5((string)time());
	}

	/**
	 * Insert Tab on string
	 *
	 * @param string $text Text to be increased.
	 * @param int $tabAmount Tab amount.
	 * @param bool $skipFirst Skip first line.
	 * @return string
	 */
	public function increaseTabOnString(string $text, int $tabAmount = 1, bool $skipFirst = false): string {
		$indent = str_repeat('    ', $tabAmount);
		$exploded = explode("\n", $text);
		$isFirst = true;
		foreach ($exploded as $key => $item) {
			if ($isFirst === true && $skipFirst === true) {
				$isFirst = false;
			} else {
				$exploded[$key] = $indent . $item;
			}

		}

		return implode("\n", $exploded);
	}

	/**
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @param bool $ajax
	 * @return string
	 */
	public function getConfigBundleAndUrlUniqueMd5(ConfigBundle $configBundle, bool $ajax = false): string {
		if ($ajax) {
			$urlMd5 = Router::getRequest()->getParam('pass.1', 'empty');
		} else {
			$urlMd5 = md5(Router::url());
		}

		return "$urlMd5.{$configBundle->getCheckMd5()}";
	}

	/**
	 * Check if a regex expression if valid.
	 *
	 * @param string $regex
	 * @return bool
	 */
	public function checkRegexFormat(string $regex): bool {
		$regexCheck = '/^((?:(?:[^?+*{}()[\]\\|]+|\\.|\[(?:\^?\\.|\^[^\\]|[^\\^])(?:[^\]\\]+|\\.)*\]|\((?:\?[:=!]|\?<[=!]|\?>)?(?1)??\)|\(\?(?:R|[+-]?\d+)\))(?:(?:[?+*]|\{\d+(?:,\d*)?\})[?+]?)?|\|)*)$/';

		return (bool)preg_match(
			$regexCheck,
			$regex
		);
	}

	/**
	 * Get association path using tree searching.
	 *
	 * @param \Cake\ORM\Table|\Cake\ORM\Association $table
	 * @param string $neededAssociation
	 * @param array $currentPath
	 * @param int $treeMax
	 * @return mixed
	 */
	public function getAssociationPath($table, string $neededAssociation, array $currentPath = [], int $treeMax = 15) {
		if (empty($currentPath)) {
			$this->getAssociationAttempt = 0;
		}
		$this->getAssociationAttempt++;
		if ($this->getAssociationAttempt > $treeMax) {
			return false;
		}
		$currentPath[] = $table->getAlias();
		if ($neededAssociation === $table->getAlias()) {
			return implode('.', $currentPath);
		}
		foreach ($table->associations() as $association) {
			$result = $this->getAssociationPath($association, $neededAssociation, $currentPath, $treeMax);
			if ($result !== false) {
				return $result;
			}
		}

		return false;
	}

	/**
	 * @param \Cake\ORM\Table $table
	 * @param string $associationPath
	 * @return \Cake\ORM\Table|\Cake\ORM\Association
	 */
	public function getAssociationUsingPath($table, string $associationPath) {
		if ($associationPath === $table->getAlias()) {
			return $table;
		}
		$paths = explode('.', $associationPath);
		if (!empty($paths[0]) && $paths[0] === $table->getAlias()) {
			unset($paths[0]);
		}

		$association = $table;
		foreach ($paths as $path) {
			$association = $association->getAssociation($path);
		}

		return $association;
	}

	/**
	 * @param string $callbackName
	 * @return string
	 */
	public function getCallBackReplaceTag(string $callbackName): string {
		$callbackName = uniqid(mb_strtoupper(Inflector::underscore($callbackName)) . '_', true);

		return "##$callbackName##";
	}

}
