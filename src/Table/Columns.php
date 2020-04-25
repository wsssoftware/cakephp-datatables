<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

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
	 * Created columns.
	 *
	 * @var \DataTables\Table\Column[]
	 */
	private $_columns = [];

	/**
	 * A selected Tables class.
	 *
	 * @var \DataTables\Table\DataTables
	 */
	private $_dataTables;

	/**
	 * Default application column configuration.
	 *
	 * @var \DataTables\Table\Column
	 */
	public $Default;

	/**
	 * Columns constructor.
	 *
	 * @param \DataTables\Table\DataTables $dataTables
	 */
	public function __construct(DataTables $dataTables) {
		$this->_dataTables = $dataTables;
		$this->Default = new Column('default', false);
	}

	/**
	 * @return \DataTables\Table\DataTables
	 */
	public function getDataTables(): DataTables {
		return $this->_dataTables;
	}

	/**
	 * Return all configured columns or all table columns if columns is empty.
	 *
	 * @return array
	 */
	public function getColumns(): array {
		if (empty($this->_columns)) {
			$table = $this->getDataTables()->getOrmTable();
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
	 * Return all configured columns.
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
	 * Return all configured columns.
	 *
	 * @param int $index
	 * @return string
	 */
	public function getColumnNameByIndex(int $index): string {
		return $this->getColumnByIndex($index)->getName();
	}

	/**
	 * Add a database column to DataTables table.
	 *
	 * @param string $dataBaseField
	 * @return \DataTables\Table\Column
	 */
	public function addDatabaseColumn(string $dataBaseField): Column {
		$columnInfo = $this->normalizeDataTableField($dataBaseField);
		$column = new Column("{$columnInfo['table']}.{$columnInfo['column']}", true, $columnInfo['columnSchema'], $columnInfo['associationPath']);
		return $this->saveColumn($column);
	}

	/**
	 * Add a non database column to DataTables table.
	 *
	 * @param string $label
	 * @return \DataTables\Table\Column
	 */
	public function addNonDatabaseColumn(string $label): Column {
		if (preg_match('/[^A-Za-z0-9]+/', $label)) {
			throw new InvalidArgumentException("On non databases fields, you must use only alphanumeric chars. Found: $label.");
		}
		$column = new Column($label, false);

		return $this->saveColumn($column);
	}

	/**
	 * Save the column on array.
	 *
	 * @param \DataTables\Table\Column $column
	 * @return \DataTables\Table\Column
	 */
	private function saveColumn(Column $column): Column {
		foreach ($this->_columns as $key => $savedColumn) {
			if ($savedColumn->getName() === $column->getName()) {
				throw new FatalErrorException("Column '{$column->getName()}' already exist in index $key.");
			}
		}
		$this->_columns[$column->getName()] = $column;

		return $column;
	}

	/**
	 * Check if class, tables, fields and associations exists, and after normalize the name.
	 *
	 * @param string $dataBaseField
	 * @return array
	 */
	public function normalizeDataTableField(string $dataBaseField): array {
		$ormTable = $this->_dataTables->getOrmTable();
		$explodedDataBaseField = explode('.', $dataBaseField);
		if (count($explodedDataBaseField) === 2) {
			$table = Inflector::camelize($explodedDataBaseField[0]);
			$column = Inflector::dasherize($explodedDataBaseField[1]);
		} elseif (count($explodedDataBaseField) == 1) {
			$table = Inflector::camelize($ormTable->getAlias());
			$column = Inflector::dasherize($explodedDataBaseField[0]);
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
