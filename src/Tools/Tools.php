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
use Cake\Utility\Text;
use Cake\View\View;
use DataTables\Js\Options;
use DataTables\StorageEngine\StorageEngineInterface;
use DataTables\Table\BuiltConfig;
use DataTables\Table\Columns;
use DataTables\Table\QueryBaseState;
use DataTables\Table\Tables;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Class Tools
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class Tools {

	/**
	 * Storage a instance of builder object.
	 *
	 * @var self
	 */
	public static $instance;

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
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Tools\Tools
	 */
	public static function getInstance(): Tools {
		if (static::$instance === null) {
			static::$instance = new self();
		}
		return static::$instance;
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
	 * @return \DataTables\Js\Options
	 */
	private function buildOptions(Tables $table): Options {
		return new Options();
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

	/**
	 * Check if the array keys and values are correct.
	 *
	 * @param array $array
	 * @param string|array $allowedKeyTypes A allowed types for array key.
	 * @param string|array $allowedValueTypes A allowed types for array value.
	 * @param string|null $inString A string to make the error more friendly.
	 * @return void
	 */
	public function checkKeysValueTypesOrFail(array $array, $allowedKeyTypes = [], $allowedValueTypes = [], string $inString = null): void {
		$allowedKeyTypesType = getType($allowedKeyTypes);
		if (!in_array($allowedKeyTypesType, ['array', 'string'])) {
			throw new FatalErrorException(sprintf('The $keyType type must be an array or string. Found : %s', $allowedKeyTypesType));
		} elseif ($allowedKeyTypesType === 'string') {
			$allowedKeyTypes = [$allowedKeyTypes];
		}
		$allowedValueTypesType = getType($allowedValueTypes);
		if (!in_array($allowedValueTypesType, ['array', 'string'])) {
			throw new FatalErrorException(sprintf('The $valueType type must be an array or string. Found : %s', $allowedValueTypesType));
		} elseif ($allowedValueTypesType === 'string') {
			$allowedValueTypes = [$allowedValueTypes];
		}
		foreach ($array as $key => $value) {
			$keyType = getType($key);
			$valueType = getType($value);
			if (!in_array($keyType, $allowedKeyTypes)) {
				$needleString = str_replace(' and ', ' or ', Text::toList($allowedKeyTypes));
				throw new InvalidArgumentException("In $inString array, the keys always must be $needleString. key: $key.");
			}
			if (!in_array($valueType, $allowedValueTypes)) {
				$needleString = str_replace(' and ', ' or ', Text::toList($allowedValueTypes));
				throw new InvalidArgumentException("In $inString array, the record $key isn't $needleString. Found: '$valueType'.");
			}
		}
	}

}
