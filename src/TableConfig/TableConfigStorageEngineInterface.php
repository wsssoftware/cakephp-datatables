<?php
/**
 * Copyright (c) Allan Carvalho 2019.
 * Under Mit License
 * php version 7.2
 *
 * @category CakePHP
 * @package  DataRenderer\Core
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-data-renderer/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-data-renderer
 */
declare(strict_types = 1);

namespace DataTables\TableConfig;

interface TableConfigStorageEngineInterface {

	/**
	 * Create or replace if exists a TableConfig for a key.
	 *
	 * @param \DataTables\TableConfig\TableConfig $config TableConfig class.
	 * @return bool True if the data was successfully saved, false on failure.
	 */
	public function save(TableConfig $config): bool;

	/**
	 * Check if exists a TableConfig for a key.
	 *
	 * @param string $key Table config name.
	 * @return bool True if the data exists, false if not.
	 */
	public function exists(string $key): bool;

	/**
	 * Read if a TableConfig for a key.
	 *
	 * @param string $key Table config name.
	 * @return \DataTables\TableConfig\TableConfig|null TableConfig class if the data was successfully read, null on not found.
	 */
	public function read(string $key): ?TableConfig;

	/**
	 * Delete if exists a TableConfig for a key.
	 *
	 * @param string $key Table config name.
	 * @return bool True if the data was successfully deleted, false on failure.
	 */
	public function delete(string $key): bool;

}
