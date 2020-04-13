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

namespace DataTables\Table;

use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use InvalidArgumentException;

/**
 * Class Columns
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
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
	 * Columns constructor.
	 *
	 * @param \DataTables\Table\Tables $tables
	 */
	public function __construct(Tables $tables) {
		$this->_tables = $tables;
	}

	/**
	 * Add a database column to DataTables table.
	 *
	 * @param string $dataBaseField
	 * @return \DataTables\Table\Column
	 */
	public function addDataBaseColumn(string $dataBaseField): Column {
		$dataBaseField = $this->normalizeDataTableField($dataBaseField);

		$column = new Column($dataBaseField, true);

		return $this->saveColumn($column);
	}

	/**
	 * Add a non database column to DataTables table.
	 *
	 * @param string $label
	 * @return \DataTables\Table\Column
	 */
	public function addNonDataBaseColumn(string $label): Column {
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
		if (!empty($this->_columns[$column->getName()])) {
			throw new FatalErrorException("Column '{$column->getName()}' already exist.");
		}
		$this->_columns[$column->getName()] = $column;
		return $column;
	}

	/**
	 * Check if class, tables, fields and associations exists, and after normalize the name.
	 *
	 * @param string $dataBaseField
	 * @return string
	 */
	private function normalizeDataTableField(string $dataBaseField): string {
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
		$dataBaseField = "$table.$column";

		if ($table === Inflector::camelize($ormTable->getAlias()) && !$ormTable->getSchema()->hasColumn($column)) {
			throw new InvalidArgumentException("The field '$column' not exists in '$table'");
		}
		if ($table !== Inflector::camelize($ormTable->getAlias())) {
			if (!$ormTable->hasAssociation($table)) {
				throw new InvalidArgumentException("The table '$table' isn't associated with '" . $ormTable->getAlias() . "'.");
			}
			/** @var \Cake\ORM\Association|\Cake\ORM\Table $association */
			$association = $ormTable->getAssociation($table);
			if (!$association->getSchema()->hasColumn($column)) {
				throw new InvalidArgumentException("The field '$column' not exists in '{$association->getAlias()}'");
			}
		}

		return $dataBaseField;
	}

}
