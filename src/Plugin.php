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

require_once __DIR__ . DS . '..' . DS . 'config' . DS . 'paths.php';

use Cake\Cache\Cache;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Error\FatalErrorException;
use Cake\Utility\Hash;

/**
 * Plugin for DataTables
 */
class Plugin extends BasePlugin {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();
	}

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
		$applicationDataTablesConfigs = Configure::read('DataTables', []);
		Configure::load('DataTables.app', 'default', true);
		$pluginDataTablesConfigs = Configure::read('DataTables', []);
		Configure::write('DataTables', Hash::merge($pluginDataTablesConfigs, $applicationDataTablesConfigs));
		unset($applicationDataTablesConfigs);
		unset($pluginDataTablesConfigs);
		if (empty(Cache::getConfig('_data_tables_built_configs_'))) {
			Cache::setConfig('_data_tables_built_configs_', Configure::read('DataTables.StorageEngine.cacheStorageEngineConfig'));
		}
	}

}
