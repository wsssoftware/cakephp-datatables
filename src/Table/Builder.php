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

namespace DataTables\Table;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use DataTables\StorageEngine\StorageEngineInterface;
use DataTables\Table\Option\MainOption;
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
	public static function getInstance(): Builder {
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
		$class = Configure::read('DataTables.StorageEngine.class');

		return new $class();
	}

	/**
	 * Get or build a ConfigBundle.
	 *
	 * @param string $dataTables  DataTables class FQN or name.
	 *     Eg.: 'Foo::main'.
	 * @param bool $cache If true will try to get from cache.
	 * @return \DataTables\Table\ConfigBundle
	 * @throws \ReflectionException
	 */
	public function getConfigBundle(string $dataTables, bool $cache = true): ConfigBundle {
		$dataTables = $this->parseClassNameToFQN($dataTables);
		$dataTablesName = explode('\\', $dataTables);
		$dataTablesName = array_pop($dataTablesName);
		$storageEngine = $this->getStorageEngine();
		$md5 = Functions::getInstance()->getClassAndVersionMd5($dataTables);
		$cacheKey = Inflector::underscore($dataTablesName);

		$configBundle = null;
		if ($cache === true && $storageEngine->exists($cacheKey)) {
			/** @var \DataTables\Table\ConfigBundle $configBundle */
			$configBundle = $storageEngine->read($cacheKey);
		}
		if (empty($configBundle) && !$configBundle instanceof ConfigBundle) {
			$configBundle = $this->buildConfigBundle($dataTables, $md5);
			if ($cache && !$storageEngine->save($cacheKey, $configBundle)) {
				throw new FatalErrorException('Unable to save the ConfigBundle cache.');
			}
		}
		$configBundle = $this->checkIfHaveCustomItemsInSession($configBundle);

		return $configBundle;
	}

	/**
	 * Build a ConfigBundle class
	 *
	 * @param string $dataTablesFQN Tables FQN class.
	 * @param string $md5 Md5 verifier used in the cache.
	 * @return \DataTables\Table\ConfigBundle
	 */
	public function buildConfigBundle(
		string $dataTablesFQN,
		string $md5
	): ConfigBundle {
		$dataTablesFQN = $this->parseClassNameToFQN($dataTablesFQN);
		$dataTables = static::getInstance()->buildDataTables($dataTablesFQN);
		$columns = static::getInstance()->buildColumns($dataTables);
		$url = Router::url([
			'controller' => 'Provider',
			'action' => 'getTablesData',
			Inflector::dasherize($dataTables->getAlias()),
			'plugin' => 'DataTables',
			'prefix' => false,
		]);
		$options = static::getInstance()->buildOptions($url);
		$queryBaseState = static::getInstance()->buildQueryBaseState();
		$configBundle = new ConfigBundle($md5, $columns, $options, $queryBaseState, $dataTablesFQN);
		$dataTables->config($configBundle);
		$configBundle->Options->setColumns($columns);

		return $configBundle;
	}

	/**
	 * Get the Tables class.
	 *
	 * @param string $dataTablesFQN Tables class with full namespace.
	 * @return \DataTables\Table\DataTables
	 */
	public function buildDataTables(string $dataTablesFQN): DataTables {
		/** @var \DataTables\Table\DataTables $dataTables */
		$dataTables = new $dataTablesFQN();
		if (!$dataTables instanceof DataTables) {
			throw new FatalErrorException("Class '$dataTablesFQN' must be an inheritance of 'DataTables'.");
		}
		return $dataTables;
	}

	/**
	 * Check if exists a custom Query and Options config for an specific url. If exists, the method will overwrite the
	 * original Options and Query.
	 *
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @return \DataTables\Table\ConfigBundle
	 */
	private function checkIfHaveCustomItemsInSession(ConfigBundle $configBundle): ConfigBundle {
		$md5s = [
			Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle),
			Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle, true),
		];
		$foundCustomOptions = false;
		$foundCustomQuery = false;
		$session = Router::getRequest()->getSession();
		foreach ($md5s as $md5) {
			if ($foundCustomOptions === false && $session->check("DataTables.configs.options.$md5")) {
				/** @var \DataTables\Table\Option\MainOption $options */
				$options = $session->read("DataTables.configs.options.$md5");
				$configBundle->Options = $options;
				$foundCustomOptions = true;
			}
			if ($foundCustomQuery === false && $session->check("DataTables.configs.query.$md5")) {
				/** @var \DataTables\Table\QueryBaseState $query */
				$query = $session->read("DataTables.configs.query.$md5");
				$configBundle->Query = $query;
				$foundCustomQuery = true;
			}
		}
		return $configBundle;
	}

	/**
	 * Get the Columns class used in the DataTables table.
	 *
	 * @param \DataTables\Table\DataTables $dataTables Tables class instance.
	 * @return \DataTables\Table\Columns
	 */
	private function buildColumns(DataTables $dataTables): Columns {
		return new Columns($dataTables);
	}

	/**
	 * Get the JsOptions class used in the DataTables table.
	 *
	 * @param string $url
	 * @return \DataTables\Table\Option\MainOption
	 */
	private function buildOptions(string $url): MainOption {
		return new MainOption($url);
	}

	/**
	 * Get the QueryBaseState class used in the DataTables table.
	 *
	 * @return \DataTables\Table\QueryBaseState
	 */
	private function buildQueryBaseState() {
		return new QueryBaseState();
	}

	/**
	 * Return the tables class FQN.
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
