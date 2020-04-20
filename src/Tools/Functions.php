<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Tools;

use Cake\Routing\Router;
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
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Tools\Functions
	 */
	public static function getInstance(): Functions {
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
	 * @return string
	 * @throws \ReflectionException
	 */
	public function getClassAndVersionMd5(string $classWithNameSpace): string {
		$classMd5 = $this->getClassMd5($classWithNameSpace);
		$versionMd5 = md5($this->getPluginCurrentVersion());

		return md5($classMd5 . $versionMd5);
	}

	/**
	 * Return the class md5
	 *
	 * @param string $classWithNameSpace Class name with namespace.
	 * @return string Md5 string
	 * @throws \ReflectionException
	 */
	public function getClassMd5(string $classWithNameSpace): string {
		return md5_file((new ReflectionClass($classWithNameSpace))->getFileName());
	}

	/**
	 * Return current package version.
	 *
	 * @return string
	 */
	public function getPluginCurrentVersion(): string {
		$version = '0';
		$packages = json_decode(file_get_contents(ROOT . DS . 'vendor' . DS . 'composer' . DS . 'installed.json'));
		foreach ($packages as $package) {
			if ($package->name === 'allanmcarvalho/cakephp-datatables') {
				$version = $package->version;
			}
		}

		return $version;
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
	 * @return string
	 */
	public function getConfigBundleAndUrlUniqueMd5(ConfigBundle $configBundle): string {
		$urlMd5 = md5(Router::url());
		return "$urlMd5.{$configBundle->getCheckMd5()}";
	}

}
