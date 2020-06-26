<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\StorageEngine;

use DataTables\Table\ConfigBundle;

/**
 * Interface StorageEngineInterface
 *
 * Created by allancarvalho in abril 17, 2020
 */
interface StorageEngineInterface {

	/**
	 * Create or replace if exists a ConfigBundle for a key.
	 *
	 * @param string $key A unique key that represent this bundle.
	 * @param \DataTables\Table\ConfigBundle $configBundle A ConfigBundle instance.
	 * @return bool True if the data was successfully saved, false on failure.
	 */
	public function save(string $key, ConfigBundle $configBundle): bool;

	/**
	 * Check a ConfigBundle exist for a key.
	 *
	 * @param string $key A unique key that represent this bundle.
	 * @return bool True if the data exists, false if not.
	 */
	public function exists(string $key): bool;

	/**
	 * Read if a ConfigBundle for a key.
	 *
	 * @param string $key A unique key that represent this bundle.
	 * @return \DataTables\Table\ConfigBundle|null ConfigBundle class if the data was successfully read, null on not found.
	 */
	public function read(string $key): ?ConfigBundle;

	/**
	 * Delete a ConfigBundle exist for a key.
	 *
	 * @param string $key A unique key that represent this bundle.
	 * @return bool True if the data was successfully deleted, false on failure.
	 */
	public function delete(string $key): bool;

}
