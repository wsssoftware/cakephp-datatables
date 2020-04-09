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


use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use Cake\Core\Configure;
use DataTables\Table\BuiltConfig;

class CacheStorageEngine implements StorageEngineInterface {

    /**
     * CacheStorageEngine constructor.
     */
	public function __construct() {
		$DataTablesCacheConfig = [
			'className' => FileEngine::class,
			'prefix' => 'table_config_',
			'path' => CACHE . 'persistent' . DS . 'data_tables' . DS,
			'serialize' => true,
			'duration' => '+' . Configure::read('DataTables.StorageEngine.duration') . ' minutes',
			'url' => env('CACHE_CAKECORE_URL', null),
		];
		if (empty(Cache::getConfig('_data_tables_'))) {
			Cache::setConfig('_data_tables_', $DataTablesCacheConfig);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function save(string $key, BuiltConfig $builtConfig): bool {
		return Cache::write($key, $builtConfig, '_data_tables_');
	}

	/**
	 * @inheritDoc
	 */
	public function exists(string $key): bool {
		return (Cache::read($key, '_data_tables_') instanceof BuiltConfig) ? true : false;
	}

	/**
	 * @inheritDoc
	 */
	public function read(string $key): ?BuiltConfig {
        /** @var BuiltConfig $builtConfig */
        $builtConfig = Cache::read($key, '_data_tables_');

		return ($builtConfig instanceof BuiltConfig) ? $builtConfig : null;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(string $key): bool {
		return Cache::delete($key, '_data_tables_');
	}

}
