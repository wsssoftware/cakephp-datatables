<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

use Cake\Database\Expression\FunctionExpression;
use Cake\Database\FunctionsBuilder;
use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use DataTables\Tools\Functions;
use InvalidArgumentException;

/**
 * Class Columns
 * Created by allancarvalho in abril 17, 2020
 */
final class Columns {

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	private $_configBundle;

	/**
	 * Created columns.
	 *
	 * @var \DataTables\Table\Column[]
	 */
	private $_columns = [];

	/**
	 * Default application column configuration.
	 *
	 * @var \DataTables\Table\Column
	 */
	public $Default;

	/**
	 * @var \Cake\Database\FunctionsBuilder|null
	 */
	private $_functionsBuilder;

	/**
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 */
	public function __construct(ConfigBundle $configBundle) {
		$this->_configBundle = $configBundle;
		$this->Default = new Column('default', false);
	}

	/**
	 * @return \DataTables\Table\ConfigBundle
	 */
	public function getConfigBundle(): ConfigBundle {
		return $this->_configBundle;
	}

	/**
	 * Add a database column to DataTables table.
	 *
	 * @param string $dataBaseField Database field name.
	 * @param int|null $index Position to insert new column.
	 * @return \DataTables\Table\Column
	 */
	public function addDatabaseColumn(string $dataBaseField, ?int $index = null): Column {
		$columnInfo = $this->normalizeDataTableField($dataBaseField);
		$column = new Column("{$columnInfo['table']}.{$columnInfo['column']}", true, $columnInfo['columnSchema'], $columnInfo['associationPath']);

		return $this->saveColumn($column, $index);
	}

	/**
	 * Add a custom database column to DataTables table.
	 * This method don't will autoload others tables, so, if you want use with a joined table, you must add it before.
	 *
	 * @param \Cake\Database\Expression\FunctionExpression $functionExpression
	 * @param string $asName
	 * @param int|null $index Position to insert new column.
	 * @return \DataTables\Table\Column
	 */
	public function addCustomDatabaseColumn(FunctionExpression $functionExpression, string $asName, ?int $index = null): Column {
		$column = new Column($asName, true, [], '', $functionExpression);

		return $this->saveColumn($column, $index);
	}

	/**
	 * Add a non database column to DataTables table.
	 *
	 * @param string $label
	 * @param int|null $index Position to insert new column.
	 * @return \DataTables\Table\Column
	 */
	public function addNonDatabaseColumn(string $label, ?int $index = null): Column {
		if (preg_match('/[^A-Za-z0-9]+/', $label)) {
			throw new InvalidArgumentException("On non databases fields, you must use only alphanumeric chars. Found: $label.");
		}
		$column = new Column($label, false);

		return $this->saveColumn($column, $index);
	}

	/**
	 * Get the query FunctionBuilder instance.
	 *
	 * @return \Cake\Database\FunctionsBuilder
	 */
	public function func(): FunctionsBuilder {
		if ($this->_functionsBuilder === null) {
			$this->_functionsBuilder = new FunctionsBuilder();
		}

		return $this->_functionsBuilder;
	}

	/**
	 * Save the column on array.
	 *
	 * @param \DataTables\Table\Column $column
	 * @param int|null $index Position to insert new column.
	 * @return \DataTables\Table\Column
	 */
	private function saveColumn(Column $column, ?int $index = null): Column {
		foreach ($this->_columns as $key => $savedColumn) {
			if ($savedColumn->getName() === $column->getName()) {
				throw new FatalErrorException("Column '{$column->getName()}' already exist in index $key.");
			}
		}
		if ($index === null) {
			$this->_columns[$column->getName()] = $column;
		} else {
			$this->_columns = array_merge(array_slice($this->_columns, 0, $index), [$column->getName() => $column], array_slice($this->_columns, $index));
		}

		return $column;
	}

	/**
	 * Change the index from some created column.
	 *
	 * @param string $columnName
	 * @param int $index
	 * @return void
	 */
	public function changeColumnIndex(string $columnName, int $index) {
		if (!empty($this->_columns[$columnName])) {
			$columnIndex = $columnName;
		}
		if (empty($columnIndex)) {
			$columnInfo = $this->normalizeDataTableField($columnName);
			$columnIndex = "{$columnInfo['table']}.{$columnInfo['column']}";
		}
		$column = [$this->_columns[$columnIndex]->getName() => $this->_columns[$columnIndex]];
		unset($this->_columns[$columnIndex]);
		$this->_columns = array_merge(array_slice($this->_columns, 0, $index), $column, array_slice($this->_columns, $index));
	}

	/**
	 * Return all configured columns or all table columns if columns is empty.
	 *
	 * @return array
	 */
	public function getColumns(): array {
		if (empty($this->_columns)) {
			$table = $this->getConfigBundle()->getDataTables()->getOrmTable();
			$columns = [];
			foreach ($table->getSchema()->columns() as $column) {
				$columnInfo = $this->normalizeDataTableField("{$table->getAlias()}.$column");
				$newColumn = new Column("{$columnInfo['table']}.{$columnInfo['column']}", true, $columnInfo['columnSchema'], $columnInfo['associationPath']);
				$columns[$newColumn->getName()] = $newColumn;
			}

			return $columns;
		}

		return $this->_columns;
	}

	/**
	 * Return a column if exists.
	 *
	 * @param string $columnName
	 * @return \DataTables\Table\Column
	 */
	public function getColumn(string $columnName): Column {
		if (!empty($this->_columns[$columnName])) {
			$columnIndex = $columnName;
		}
		if (empty($columnIndex)) {
			$columnInfo = $this->normalizeDataTableField($columnName);
			$columnIndex = "{$columnInfo['table']}.{$columnInfo['column']}";
		}

		return $this->_columns[$columnIndex];
	}

	/**
	 * Return column by passed index.
	 *
	 * @param int $index
	 * @return \DataTables\Table\Column
	 */
	public function getColumnByIndex(int $index): Column {
		$columns = $this->getColumns();
		$columns = array_values($columns);

		return $columns[$index];
	}

	/**
	 * Get the column index by name.
	 *
	 * @param string $columnName
	 * @return int
	 */
	public function getColumnIndexByName(string $columnName): int {
		if (!empty($this->_columns[$columnName])) {
			$columnIndex = $columnName;
		}
		if (empty($columnIndex)) {
			$columnInfo = $this->normalizeDataTableField($columnName);
			$columnIndex = "{$columnInfo['table']}.{$columnInfo['column']}";
		}
		$columns = $this->getColumns();
		$currentIndex = 0;
		foreach ($columns as $key => $column) {
			if ($key === $columnIndex) {
				return $currentIndex;
			}
			$currentIndex++;
		}

		return -1;
	}

	/**
	 * Return all configured columns.
	 *
	 * @param int $index
	 * @return string
	 */
	public function getColumnNameByIndex(int $index): string {
		return $this->getColumnByIndex($index)->getName();
	}

	/**
	 * Delete a columns with provided name.
	 *
	 * @param string $columnName
	 * @return void
	 */
	public function deleteColumn(string $columnName): void {
		if (!empty($this->_columns[$columnName])) {
			$columnIndex = $columnName;
		}
		if (empty($columnIndex)) {
			$columnInfo = $this->normalizeDataTableField($columnName);
			$columnIndex = "{$columnInfo['table']}.{$columnInfo['column']}";
		}
		unset($this->_columns[$columnIndex]);
	}

	/**
	 * Delete all configured columns
	 *
	 * @return void
	 */
	public function deleteAllColumns(): void {
		$this->_columns = [];
	}

	/**
	 * Check if class, tables, fields and associations exists, and after normalize the name.
	 *
	 * @param string $dataBaseField
	 * @return array
	 */
	public function normalizeDataTableField(string $dataBaseField): array {
		$ormTable = $this->getConfigBundle()->getDataTables()->getOrmTable();
		$explodedDataBaseField = explode('.', $dataBaseField);
		if (count($explodedDataBaseField) === 2) {
			$table = Inflector::camelize($explodedDataBaseField[0]);
			$column = Inflector::underscore($explodedDataBaseField[1]);
		} elseif (count($explodedDataBaseField) == 1) {
			$table = Inflector::camelize($ormTable->getAlias());
			$column = Inflector::underscore($explodedDataBaseField[0]);
		} else {
			throw new InvalidArgumentException("$dataBaseField is a invalid \$dataBaseField.");
		}
		$associationPath = Functions::getInstance()->getAssociationPath($ormTable, $table);
		if ($associationPath === false) {
			throw new InvalidArgumentException("The table '$table' isn't associated with '" . $ormTable->getAlias() . "' or with its associations.");
		}
		$association = Functions::getInstance()->getAssociationUsingPath($ormTable, $associationPath);
		if (!$association->getSchema()->hasColumn($column)) {
			throw new InvalidArgumentException("The field '$column' not exists in '$table'");
		}
		$columnSchema = $association->getSchema()->getColumn($column);

		return [
			'table' => $table,
			'column' => $column,
			'columnSchema' => $columnSchema,
			'associationPath' => $associationPath,
		];
	}

}
