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

use Cake\Cache\Cache;
use DataTables\Table\BuiltConfig;

/**
 * Class CacheStorageEngine
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class CacheStorageEngine implements StorageEngineInterface {

	/**
	 * @inheritDoc
	 */
	public function save(string $key, BuiltConfig $builtConfig): bool {
		return Cache::write($key, $builtConfig, '_data_tables_built_configs_');
	}

	/**
	 * @inheritDoc
	 */
	public function exists(string $key): bool {
		return (Cache::read($key, '_data_tables_built_configs_') instanceof BuiltConfig) ? true : false;
	}

	/**
	 * @inheritDoc
	 */
	public function read(string $key): ?BuiltConfig {
		$builtConfig = Cache::read($key, '_data_tables_built_configs_');
		return ($builtConfig instanceof BuiltConfig) ? $builtConfig : null;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(string $key): bool {
		return Cache::delete($key, '_data_tables_built_configs_');
	}

}
