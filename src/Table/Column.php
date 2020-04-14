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

use InvalidArgumentException;

/**
 * Class Column
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
final class Column {

	/**
	 * The column name.
	 *
	 * @var string
	 */
	private $_name;

	/**
	 * If the column is or not a database column.
	 *
	 * @var bool
	 */
	private $_database;

	/**
	 * If the column is or not a database column.
	 *
	 * @var array
	 */
	private $_columnSchema;

	/**
	 * @var string
	 */
	private $_cellType = 'td';

	/**
	 * Column constructor.
	 *
	 * @param string $name
	 * @param bool $database
	 * @param array $columnSchema
	 */
	public function __construct(string $name, bool $database = true, array $columnSchema = []) {
		$this->_name = $name;
		$this->_database = $database;
		$this->_columnSchema = $columnSchema;
	}

	/**
	 * Get column name
	 *
	 * @return string
	 */
	public function getName(): string {
		return $this->_name;
	}

	/**
	 * Check if is a database column or not.
	 *
	 * @return bool
	 */
	public function isDatabase(): bool {
		return $this->_database;
	}

	/**
	 * Getter method.
	 * Change the cell type created for the column - either TD cells or TH cells.
	 * This can be useful as TH cells have semantic meaning in the table body, allowing them to act as a header for a
	 * row (you may wish to add scope='row' to the TH elements using columns.createdCell option).
	 *
	 * @return string
	 * @link https://datatables.net/reference/option/columns.cellType
	 */
	public function getCellType(): string {
		return $this->_cellType;
	}

	/**
	 * Setter method.
	 * Change the cell type created for the column - either TD cells or TH cells.
	 * This can be useful as TH cells have semantic meaning in the table body, allowing them to act as a header for a
	 * row (you may wish to add scope='row' to the TH elements using columns.createdCell option).
	 *
	 * @param string $cellType
	 * @return \DataTables\Table\Column
	 * @link https://datatables.net/reference/option/columns.cellType
	 */
	public function setCellType(string $cellType): self {
		if (!in_array($cellType, ['td', 'th'])) {
			throw new InvalidArgumentException("\$cellType must be 'td' or 'th'. Found: $cellType.");
		}
		$this->_cellType = $cellType;
		return $this;
	}

}
