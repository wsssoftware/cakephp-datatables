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

namespace DataTables\StorageEngine;

use DataTables\Table\BuiltConfig;

/**
 * Interface StorageEngineInterface
 *
 * @package DataTables\StorageEngine
 */
interface StorageEngineInterface {

	/**
	 * Create or replace if exists a BuiltConfig for a key.
	 *
	 * @param string $key A unique key that represent this built.
	 * @param \DataTables\Table\BuiltConfig $builtConfig A BuiltConfig instance.
	 * @return bool True if the data was successfully saved, false on failure.
	 */
	public function save(string $key, BuiltConfig $builtConfig): bool;

	/**
	 * Check a BuiltConfig exist for a key.
	 *
	 * @param string $key A unique key that represent this built.
	 * @return bool True if the data exists, false if not.
	 */
	public function exists(string $key): bool;

	/**
	 * Read if a BuiltConfig for a key.
	 *
	 * @param string $key A unique key that represent this built.
	 * @return \DataTables\Table\BuiltConfig|null BuiltConfig class if the data was successfully read, null on not found.
	 */
	public function read(string $key): ?BuiltConfig;

	/**
	 * Delete a BuiltConfig exist for a key.
	 *
	 * @param string $key A unique key that represent this built.
	 * @return bool True if the data was successfully deleted, false on failure.
	 */
	public function delete(string $key): bool;

}
