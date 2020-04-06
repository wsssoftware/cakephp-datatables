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

namespace DataTables\TableConfig\Engine;

use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use DataTables\TableConfig\TableConfig;
use DataTables\TableConfig\TableConfigStorageEngineInterface;

class CacheEngine implements TableConfigStorageEngineInterface {

	public function __construct() {
		$DataTablesCacheConfig = [
			'className' => FileEngine::class,
			'prefix' => 'table_config_',
			'path' => CACHE . 'persistent' . DS . 'data_tables' . DS,
			'serialize' => true,
			'duration' => '+1 years',
			'url' => env('CACHE_CAKECORE_URL', null),
		];
		if (empty(Cache::getConfig('_data_tables_'))) {
			Cache::setConfig('_data_tables_', $DataTablesCacheConfig);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function save(TableConfig $config): bool {
		return Cache::write($config->getConfigName(), $config, '_data_tables_');
	}

	/**
	 * @inheritDoc
	 */
	public function exists(string $key): bool {
		return (Cache::read($key, '_data_tables_') instanceof TableConfig) ? true : false;
	}

	/**
	 * @inheritDoc
	 */
	public function read(string $key): ?TableConfig {
		$tableConfig = Cache::read($key, '_data_tables_');

		return ($tableConfig instanceof TableConfig) ? $tableConfig : null;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(string $key): bool {
		return Cache::delete($key, '_data_tables_');
	}

}
