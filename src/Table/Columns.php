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

use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use InvalidArgumentException;

/**
 * Class Columns
 *
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
	 * @var \DataTables\Table\Tables
	 */
	private $_tables;

	/**
	 * Default application column configuration.
	 *
	 * @var \DataTables\Table\Column
	 */
	public $Default;

	/**
	 * Columns constructor.
	 *
	 * @param \DataTables\Table\Tables $tables
	 */
	public function __construct(Tables $tables) {
		$this->_tables = $tables;
		$this->Default = new Column('default', 'empty', false);
	}

	/**
	 * Return all configured columns.
	 *
	 * @return array
	 */
	public function getColumns(): array {
		return $this->_columns;
	}

	/**
	 * Add a database column to DataTables table.
	 *
	 * @param string $dataBaseField
	 * @param string|null $title
	 * @return \DataTables\Table\Column
	 */
	public function addDatabaseColumn(string $dataBaseField, ?string $title = null): Column {
		$column = $this->normalizeDataTableField($dataBaseField, $title);
		return $this->saveColumn($column);
	}

	/**
	 * Add a non database column to DataTables table.
	 *
	 * @param string $label
	 * @param string|null $title
	 * @return \DataTables\Table\Column
	 */
	public function addNonDatabaseColumn(string $label, ?string $title = null): Column {
		$column = new Column($label, $title, false);
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
		$this->_columns[] = $column;
		return $column;
	}

	/**
	 * Check if class, tables, fields and associations exists, and after normalize the name.
	 *
	 * @param string $dataBaseField
	 * @param string|null $title
	 * @return \DataTables\Table\Column
	 */
	private function normalizeDataTableField(string $dataBaseField, ?string $title): Column {
		$ormTable = $this->_tables->getOrmTable();
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

		if ($table === Inflector::camelize($ormTable->getAlias())) {
			if (!$ormTable->getSchema()->hasColumn($column)) {
				throw new InvalidArgumentException("The field '$column' not exists in '$table'");
			}
			$columnSchema = $this->_tables->getOrmTable()->getSchema()->getColumn($column);
		} else {
			if (!$ormTable->hasAssociation($table)) {
				throw new InvalidArgumentException("The table '$table' isn't associated with '" . $ormTable->getAlias() . "'.");
			}
			/** @var \Cake\ORM\Association|\Cake\ORM\Table $association */
			$association = $ormTable->getAssociation($table);
			if (!$association->getSchema()->hasColumn($column)) {
				throw new InvalidArgumentException("The field '$column' not exists in '{$association->getAlias()}'");
			}
			$columnSchema = $association->getSchema()->getColumn($column);
		}
		$column = new Column("$table.$column", $title, true, $columnSchema);

		return $column;
	}

}
