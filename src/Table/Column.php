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
	 * @var string|null
	 */
	private $_cellType = null;

	/**
	 * @var string|null
	 */
	private $_className = null;

	/**
	 * @var string|null
	 */
	private $_contentPadding = null;

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
	 * @return string|null
	 * @link https://datatables.net/reference/option/columns.cellType
	 */
	public function getCellType(): ?string {
		return $this->_cellType;
	}

	/**
	 * Setter method.
	 * Change the cell type created for the column - either TD cells or TH cells.
	 * This can be useful as TH cells have semantic meaning in the table body, allowing them to act as a header for a
	 * row (you may wish to add scope='row' to the TH elements using columns.createdCell option).
	 *
	 * @param string|null $cellType
	 * @return \DataTables\Table\Column
	 * @link https://datatables.net/reference/option/columns.cellType
	 */
	public function setCellType(?string $cellType): self {
		if (!in_array($cellType, ['td', 'th'])) {
			throw new InvalidArgumentException("\$cellType must be 'td' or 'th'. Found: $cellType.");
		}
		$this->_cellType = $cellType;
		return $this;
	}

	/**
	 * Getter method.
	 * Quite simply this option adds a class to each cell in a column, regardless of if the table source is from DOM,
	 * Javascript or Ajax. This can be useful for styling columns.
	 *
	 * @return string|null
	 * @link https://datatables.net/reference/option/columns.className
	 */
	public function getClassName(): ?string {
		return $this->_className;
	}

	/**
	 * Setter method.
	 * Quite simply this option adds a class to each cell in a column, regardless of if the table source is from DOM,
	 * Javascript or Ajax. This can be useful for styling columns.
	 *
	 * @param string|null $className
	 * @return \DataTables\Table\Column
	 * @link https://datatables.net/reference/option/columns.className
	 */
	public function setClassName(?string $className): self {
		$this->_className = $className;
		return $this;
	}

	/**
	 * Getter method.
	 * Quite simply this option adds a class to each cell in a column, regardless of if the table source is from DOM,
	 * Javascript or Ajax. This can be useful for styling columns.
	 *
	 * @return string|null
	 * @link https://datatables.net/reference/option/columns.contentPadding
	 */
	public function getContentPadding(): ?string {
		return $this->_contentPadding;
	}

	/**
	 * Setter method.
	 * The first thing to say about this property is that generally you shouldn't need this!
	 *
	 * Having said that, it can be useful on rare occasions. When DataTables calculates the column widths to assign to
	 * each column, it finds the longest string in each column and then constructs a temporary table and reads the
	 * widths from that. The problem with this is that "mmm" is much wider then "iiii", but the latter is a longer
	 * string - thus the calculation can go wrong (doing it properly and putting it into an DOM object and measuring
	 * that is horribly slow!). Thus as a "work around" we provide this option. It will append its value to the text
	 * that is found to be the longest string for the column - i.e. padding.
	 *
	 * @param string $contentPadding
	 * @return \DataTables\Table\Column
	 * @link https://datatables.net/reference/option/columns.contentPadding
	 */
	public function setContentPadding(?string $contentPadding): self {
		$this->_contentPadding = $contentPadding;
		return $this;
	}

}
