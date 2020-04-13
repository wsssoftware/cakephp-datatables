<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Tools;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\View\View;
use DataTables\Option\MainOption;
use DataTables\StorageEngine\StorageEngineInterface;
use DataTables\Table\BuiltConfig;
use DataTables\Table\Columns;
use DataTables\Table\QueryBaseState;
use DataTables\Table\Tables;
use ReflectionClass;

/**
 * Class Tools
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class Builder {

	/**
	 * Storage a instance of object.
	 *
	 * @var self
	 */
	public static $instance;

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
	 * Built a BuiltConfig class
	 *
	 * @param string $tablesClassWithNameSpace Tables class with full namespace.
	 * @param string $configMethod The method that will be called.
	 * @param \Cake\View\View $view View class to generate the cell.
	 * @param string $md5 Md5 verifier used in the cache.
	 * @return \DataTables\Table\BuiltConfig
	 */
	public function buildBuiltConfig(string $tablesClassWithNameSpace, string $configMethod, View $view, string $md5): BuiltConfig {
		$tables = static::getInstance()->buildTables($tablesClassWithNameSpace, $configMethod);
		$queryBaseState = static::getInstance()->buildQueryBaseState($tables);
		$columns = static::getInstance()->buildColumns($tables);
		$options = static::getInstance()->buildOptions($tables);
		$tables->{$configMethod . 'Config'}($queryBaseState, $columns, $options);
		$renderedTable = $view->cell('DataTables.DataTables::table', [$columns])->render();
		return new BuiltConfig($md5, $renderedTable, $queryBaseState, $columns, $options);
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
	 * Get the QueryBaseState class used in the DataTables table.
	 *
	 * @param \DataTables\Table\Tables $table Tables class instance.
	 * @return \DataTables\Table\QueryBaseState
	 */
	private function buildQueryBaseState(Tables $table) {
		return new QueryBaseState();
	}

	/**
	 * Get the Columns class used in the DataTables table.
	 *
	 * @param \DataTables\Table\Tables $table Tables class instance.
	 * @return \DataTables\Table\Columns
	 */
	private function buildColumns(Tables $table): Columns {
		return new Columns();
	}

	/**
	 * Get the JsOptions class used in the DataTables table.
	 *
	 * @param \DataTables\Table\Tables $table Tables class instance.
	 * @return \DataTables\Option\MainOption
	 */
	private function buildOptions(Tables $table): MainOption {
		return new MainOption();
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
	 * Return the Tables class md5
	 *
	 * @param string $tablesClassWithNameSpace Tables class name with namespace.
	 * @return string Md5 string
	 * @throws \ReflectionException
	 */
	public function getTablesMd5(string $tablesClassWithNameSpace): string {
		return md5_file((new ReflectionClass($tablesClassWithNameSpace))->getFileName());
	}

}
