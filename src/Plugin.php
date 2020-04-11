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

namespace DataTables;

require __DIR__ . DS . '..' . DS . 'config' . DS . 'paths.php';

use Cake\Cache\Cache;
use Cake\Cache\Engine\FileEngine;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Error\FatalErrorException;

/**
 * Plugin for DataTables
 */
class Plugin extends BasePlugin {

	/**
	 * Load all the plugin configuration and bootstrap logic.
	 *
	 * The host application is provided as an argument. This allows you to load
	 * additional plugin dependencies, or attach events.
	 *
	 * @param \Cake\Core\PluginApplicationInterface $app The host application
	 * @return void
	 */
	public function bootstrap(PluginApplicationInterface $app): void {
		$applicationDataTablesConfigs = Configure::read('DataTables', []);
		if (!is_array($applicationDataTablesConfigs)) {
			throw new FatalErrorException('DataTables config key must contain an array');
		}
		Configure::load('DataTables.app', 'default', true);
		foreach ($applicationDataTablesConfigs as $config => $value) {
			$this->mergeConfiguration('DataTables', (string)$config, $value);
		}
		if (empty(Cache::getConfig('_data_tables_built_configs_'))) {
			Cache::setConfig('_data_tables_built_configs_', [
				'className' => FileEngine::class,
				'prefix' => 'built_config_',
				'path' => CACHE . DS . 'data_tables' . DS . 'built_configs' . DS,
				'serialize' => true,
				'duration' => '+' . Configure::read('DataTables.StorageEngine.duration') . ' minutes',
				'url' => env('CACHE_CAKECORE_URL', null),
			]);
		}
	}

	/**
	 * Merge item by item between plugin and application configuration
	 *
	 * @param string $currentPath Current Path to save in configuration
	 * @param string $config Configuration key
	 * @param mixed $value Configuration value
	 * @return void
	 */
	private function mergeConfiguration(string $currentPath, string $config, $value) {
		if (is_array($value)) {
			foreach ($value as $childConfig => $childValue) {
				$this->mergeConfiguration("$currentPath.$config", (string)$childConfig, $childValue);
			}
		} else {
			Configure::write("$currentPath.$config", $value);
		}
	}

}
