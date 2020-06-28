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

namespace DataTables\Table;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use DataTables\StorageEngine\StorageEngineInterface;
use DataTables\Table\Configure as TableConfigure;
use DataTables\Tools\Functions;

/**
 * Class Builder
 * Created by allancarvalho in abril 17, 2020
 */
final class Builder {

	/**
	 * Storage a instance of object.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Table\Builder
	 */
	public static function getInstance() {
		if (static::$instance === null) {
			static::$instance = new self();
		}

		return static::$instance;
	}

	/**
	 * Get the configured storage engine.
	 *
	 * @return \DataTables\StorageEngine\StorageEngineInterface
	 */
	public function getStorageEngine(): StorageEngineInterface {
		$class = TableConfigure::getInstance()->getStorageEngine();

		return new $class();
	}

	/**
	 * Get a ConfigBundle if it exists in cache or build a new.
	 *
	 * @param string $dataTables DataTables class FQN or name.
	 * @param bool $cache If true will try to get from cache.
	 * @throws \ReflectionException
	 * @return \DataTables\Table\ConfigBundle
	 */
	public function getConfigBundle(string $dataTables, bool $cache = true): ConfigBundle {
		$dataTablesFQN = $this->parseClassNameToFQN($dataTables);
		$dataTablesName = explode('\\', $dataTables);
		$dataTablesName = array_pop($dataTablesName);
		$configure = TableConfigure::getInstance();
		$appDataTablesClassFqn = Configure::read('App.namespace') . '\\DataTables\\AppDataTables';
		if (class_exists($appDataTablesClassFqn)) {
			$appDataTablesClass = new $appDataTablesClassFqn();
			if (method_exists($appDataTablesClass, 'configure')) {
				$appDataTablesClass->configure($configure);
			}
		} else {
			throw new FatalErrorException(sprintf('The AppDataTables class was not found in "%s".', $appDataTablesClassFqn));
		}
		$storageEngine = $this->getStorageEngine();
		$md5 = Functions::getInstance()->getClassAndVersionMd5($dataTablesFQN);
		$cacheKey = Inflector::underscore($dataTablesName);
		$configBundle = null;
		if ($cache === true && $storageEngine->exists($cacheKey)) {
			/** @var \DataTables\Table\ConfigBundle $configBundle */
			$configBundle = $storageEngine->read($cacheKey);
			Assets::getInstance()->applyConfig($configBundle->Assets);
		}
		if (empty($configBundle) || $configBundle->getCheckMd5() !== $md5) {
			$configBundle = new ConfigBundle($md5, $dataTablesFQN, $appDataTablesClass);
			if ($cache && !$storageEngine->save($cacheKey, $configBundle)) {
				throw new FatalErrorException('Unable to save the ConfigBundle cache.');
			}
		}
		$configBundle = $this->checkIfHaveCustomItemsInSession($configBundle);

		return $configBundle;
	}

	/**
	 * Check if exists a custom Columns, Options and/or Query config for a specific url. If exists, the method will
	 * overwrite the original Options and Query.
	 *
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @return \DataTables\Table\ConfigBundle
	 */
	private function checkIfHaveCustomItemsInSession(ConfigBundle $configBundle): ConfigBundle {
		$md5s = [
			Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle),
			Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle, true),
		];
		$foundCustomColumns = false;
		$foundCustomOptions = false;
		$foundCustomQuery = false;
		$session = Router::getRequest()->getSession();
		foreach ($md5s as $md5) {
			if ($foundCustomColumns === false && $session->check("DataTables.configs.columns.$md5")) {
				/** @var \DataTables\Table\Columns $columns */
				$columns = $session->read("DataTables.configs.columns.$md5");
				$configBundle->Columns = $columns;
				$configBundle->Options->setColumns($columns);
				$foundCustomColumns = true;
			}
			if ($foundCustomOptions === false && $session->check("DataTables.configs.options.$md5")) {
				$configBundle->Options = $session->read("DataTables.configs.options.$md5");
				$foundCustomOptions = true;
			}
			if ($foundCustomQuery === false && $session->check("DataTables.configs.query.$md5")) {
				$configBundle->Query = $session->read("DataTables.configs.query.$md5");
				$foundCustomQuery = true;
			}
		}

		return $configBundle;
	}

	/**
	 * Return the DataTables class FQN.
	 *
	 * @param string $dataTablesName
	 * @return string
	 */
	private function parseClassNameToFQN(string $dataTablesName): string {
		$expectedPath = Configure::read('App.namespace') . '\\DataTables\\';
		if (count(explode('\\', $dataTablesName)) === 1) {
			$dataTablesName = $expectedPath . $dataTablesName . 'DataTables';
		}
		if (!class_exists($dataTablesName)) {
			throw new FatalErrorException("Class '$dataTablesName' not found.");
		}
		if (strpos($dataTablesName, $expectedPath) === false) {
			throw new FatalErrorException("All DataTables class must stay in '$expectedPath'. Found: '$dataTablesName'.");
		}

		return $dataTablesName;
	}

}
