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
	 * Column constructor.
	 *
	 * @param string $name
	 * @param bool $database
	 */
	public function __construct(string $name, bool $database = true) {
		$this->_name = $name;
		$this->_database = $database;
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

}
