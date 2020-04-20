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
		$options = static::getInstance()->buildOptions();
		$queryBaseState = static::getInstance()->buildQueryBaseState();
		$configBundle = new ConfigBundle($md5, $columns, $options, $queryBaseState, $tablesClass, $configMethod);
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
	 * @return \DataTables\Table\Builder
	 */
	public static function getInstance(): Builder {
		if (static::$instance === null) {
			static::$instance = new self();
		}

		return static::$instance;
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
	 * @return \DataTables\Table\Option\MainOption
	 */
	private function buildOptions(): MainOption {
		return new MainOption();
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

}
