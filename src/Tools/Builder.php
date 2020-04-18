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

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use DataTables\StorageEngine\StorageEngineInterface;
use DataTables\Table\Columns;
use DataTables\Table\ConfigBundle;
use DataTables\Table\CustomRotesConfig;
use DataTables\Table\Option\MainOption;
use DataTables\Table\QueryBaseState;
use DataTables\Table\Tables;
use InvalidArgumentException;

/**
 * Class Builder
 * Created by allancarvalho in abril 17, 2020
 */
class Builder {

	/**
	 * Storage a instance of object.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Get or build a ConfigBundle.
	 *
	 * @param string $tableAndConfig A Tables class plus config method that you want to render concatenated by '::'.
	 *     Eg.: 'Foo::main'.
	 * @param bool $cache If true will try to get from cache.
	 * @return \DataTables\Table\ConfigBundle
	 * @throws \ReflectionException
	 */
	public function getConfigBundle(string $tableAndConfig, bool $cache = true): ConfigBundle {
		$exploded = explode('::', $tableAndConfig);
		if (count($exploded) !== 2) {
			throw new InvalidArgumentException('Table param must be a concatenation of Tables class and config. Eg.: Foo::method.');
		}
		$storageEngine = $this->getStorageEngine();
		$tablesClass = $exploded[0];
		$configMethod = $exploded[1];
		$md5 = Functions::getInstance()->getClassAndVersionMd5($this->getTablesClassFQN($tablesClass));
		$cacheKey = Inflector::underscore(str_replace('::', '_', $tableAndConfig));

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

		return $configBundle;
	}

	/**
	 * Return the tables class FQN.
	 *
	 * @param string $tables
	 * @return string
	 */
	private function getTablesClassFQN(string $tables): string {
		$exploded = explode('::', $tables);
		$tablesClass = $exploded[0];
		$tablesFQN = Configure::read('App.namespace') . '\\DataTables\\Tables\\' . $tablesClass . 'Tables';
		if (class_exists($tablesFQN) === false) {
			throw new FatalErrorException("Class '$tablesFQN' not found.");
		}

		return $tablesFQN;
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
		$customRotesConfig = static::getInstance()->buildCustomRotesConfig($tables);
		$columns = static::getInstance()->buildColumns($tables);
		$url = Router::url(['controller' => 'Provider', 'action' => 'getData', $tablesClass, $configMethod, 'plugin' => 'DataTables', 'prefix' => false], true);
		$options = static::getInstance()->buildOptions($tables, $url);
		$queryBaseState = static::getInstance()->buildQueryBaseState($tables);
		$configBundle = new ConfigBundle($md5, $customRotesConfig, $columns, $options, $queryBaseState);
		$tables->{$configMethod . 'Config'}($configBundle);

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
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Tools\Builder
	 */
	public static function getInstance(): Builder {
		if (static::$instance === null) {
			static::$instance = new self();
		}

		return static::$instance;
	}

	/**
	 * Get the CustomRotesConfig class used in the DataTables table.
	 *
	 * @param \DataTables\Table\Tables $table Tables class instance.
	 * @return \DataTables\Table\CustomRotesConfig
	 */
	private function buildCustomRotesConfig(Tables $table): CustomRotesConfig {
		return new CustomRotesConfig($table);
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
	 * @param \DataTables\Table\Tables $table Tables class instance.
	 * @param string $url
	 * @return \DataTables\Table\Option\MainOption
	 */
	private function buildOptions(Tables $table, string $url): MainOption {
		return new MainOption($url);
	}

	/**
	 * Get the QueryBaseState class used in the DataTables table.
	 *
	 * @param \DataTables\Table\Tables $table Tables class instance.
	 * @return \DataTables\Table\QueryBaseState
	 */
	private function buildQueryBaseState(Tables $table) {
		return new QueryBaseState();
	}

}
