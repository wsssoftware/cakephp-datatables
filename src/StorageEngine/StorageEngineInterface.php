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

namespace DataTables\StorageEngine;

use DataTables\Table\BuiltConfig;

interface StorageEngineInterface {

    /**
     * Create or replace if exists a BuiltConfig for a key.
     *
     * @param string $key A unique key that represent this built.
     * @param BuiltConfig $builtConfig A BuiltConfig instance.
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
	 * @return BuiltConfig|null BuiltConfig class if the data was successfully read, null on not found.
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
