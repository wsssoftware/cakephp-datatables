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

use Cake\Cache\Cache;
use DataTables\Table\ConfigBundle;

/**
 * Class CacheStorageEngine
 *
 * Created by allancarvalho in abril 17, 2020
 */
class CacheStorageEngine implements StorageEngineInterface {

	/**
	 * @var string
	 */
	private $_cacheConfigName = '_data_tables_config_bundles_';

	/**
	 * @param string|null $cacheConfigName
	 */
	public function __construct(?string $cacheConfigName = null) {
		if (!empty($cacheConfigName)) {
			$this->_cacheConfigName = $cacheConfigName;
		}
		Cache::getConfigOrFail($this->_cacheConfigName);
	}

	/**
	 * @inheritDoc
	 */
	public function save(string $key, ConfigBundle $configBundle): bool {
		return Cache::write($key, $configBundle, $this->_cacheConfigName);
	}

	/**
	 * @inheritDoc
	 */
	public function exists(string $key): bool {
		return Cache::read($key, $this->_cacheConfigName) instanceof ConfigBundle;
	}

	/**
	 * @inheritDoc
	 */
	public function read(string $key): ?ConfigBundle {
		$configBundle = Cache::read($key, $this->_cacheConfigName);

		return ($configBundle instanceof ConfigBundle) ? $configBundle : null;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(string $key): bool {
		return Cache::delete($key, $this->_cacheConfigName);
	}

}
