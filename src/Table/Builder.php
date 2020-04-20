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
use InvalidArgumentException;

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
	 * @param string $tablesAndConfig A Tables class plus config method that you want to render concatenated by '::'.
	 *     Eg.: 'Foo::main'.
	 * @param bool $cache If true will try to get from cache.
	 * @return \DataTables\Table\ConfigBundle
	 * @throws \ReflectionException
	 */
	public function getConfigBundle(string $tablesAndConfig, bool $cache = true): ConfigBundle {
		$exploded = explode('::', $tablesAndConfig);
		if (count($exploded) !== 2) {
			throw new InvalidArgumentException('Table param must be a concatenation of Tables class and config. Eg.: Foo::method.');
		}
		$storageEngine = $this->getStorageEngine();
		$tablesClass = $exploded[0];
		$configMethod = $exploded[1];
		$md5 = Functions::getInstance()->getClassAndVersionMd5($this->getTablesClassFQN($tablesClass));
		$cacheKey = Inflector::underscore(str_replace('::', '_', $tablesAndConfig));

		$configBundle = null;
		if ($cache === true && $storageEngine->exists($cacheKey)) {
			/** @var \DataTables\Table\ConfigBundle $configBundle */
			$configBundle = $storageEngine->read($cacheKey);
		}
		if (empty($configBundle) && !$configBundle instanceof ConfigBundle) {
			$configBundle = $this->buildConfigBundle($tablesClass, $configMethod, $md5);
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
	 * @param string $tablesClass Tables class.
	 * @param string $configMethod The method that will be called.
	 * @param string $md5 Md5 verifier used in the cache.
	 * @return \DataTables\Table\ConfigBundle
	 */
	public function buildConfigBundle(
		string $tablesClass,
		string $configMethod,
		string $md5
	): ConfigBundle {
		$tables = static::getInstance()->buildTables($this->getTablesClassFQN($tablesClass), $configMethod);
		$columns = static::getInstance()->buildColumns($tables);
		$url = Router::url([
			'controller' => 'Provider',
			'action' => 'getTablesData',
			$tablesClass,
			$configMethod,
			'plugin' => 'DataTables',
			'prefix' => false,
		]);
		$options = static::getInstance()->buildOptions($url);
		$queryBaseState = static::getInstance()->buildQueryBaseState();
		$configBundle = new ConfigBundle($md5, $columns, $options, $queryBaseState, $tablesClass, $configMethod);
		$tables->{$configMethod . 'Config'}($configBundle);
		$configBundle->Options->Columns->setColumns($columns);

		return $configBundle;
	}

	/**
	 * Get the Tables class.
	 *
	 * @param string $tablesClassWithNameSpace Tables class with full namespace.
	 * @param string $configMethod The method that will be called.
	 * @return \DataTables\Table\Tables
	 */
	public function buildTables(string $tablesClassWithNameSpace, string $configMethod): Tables {
		/** @var \DataTables\Table\Tables $tables */
		$tables = new $tablesClassWithNameSpace();
		if (empty($tables)) {
			throw new FatalErrorException("Tables class '$tablesClassWithNameSpace' not found.");
		}
		if (!method_exists($tables, $configMethod . 'Config')) {
			throw new FatalErrorException("Config method '{$configMethod}Config' don't exist in '$tablesClassWithNameSpace'.");
		}

		return $tables;
	}

	/**
	 * Check if exists a custom Query and Options config for an specific url. If exists, the method will overwrite the
	 * original Options and Query.
	 *
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @return \DataTables\Table\ConfigBundle
	 */
	private function checkIfHaveCustomItemsInSession(ConfigBundle $configBundle): ConfigBundle {
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		$session = Router::getRequest()->getSession();
		if ($session->check("DataTables.configs.options.$md5")) {
			/** @var \DataTables\Table\Option\MainOption $options */
			$options = $session->read("DataTables.configs.options.$md5");
			$configBundle->Options = $options;
		}
		if ($session->check("DataTables.configs.query.$md5")) {
			/** @var \DataTables\Table\QueryBaseState $query */
			$query = $session->read("DataTables.configs.query.$md5");
			$configBundle->Query = $query;
		}
		return $configBundle;
	}

	/**
	 * Get the Columns class used in the DataTables table.
	 *
	 * @param \DataTables\Table\Tables $table Tables class instance.
	 * @return \DataTables\Table\Columns
	 */
	private function buildColumns(Tables $table): Columns {
		return new Columns($table);
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
	 * @param string $tablesName
	 * @return string
	 */
	private function getTablesClassFQN(string $tablesName): string {
		$exploded = explode('::', $tablesName);
		$tablesClass = $exploded[0];
		$tablesFQN = Configure::read('App.namespace') . '\\DataTables\\Tables\\' . $tablesClass . 'Tables';
		if (class_exists($tablesFQN) === false) {
			throw new FatalErrorException("Class '$tablesFQN' not found.");
		}

		return $tablesFQN;
	}

}
