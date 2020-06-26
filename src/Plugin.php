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

namespace DataTables;

require_once __DIR__ . DS . '..' . DS . 'config' . DS . 'paths.php';

use Cake\Cache\Cache;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Error\FatalErrorException;
use Cake\Utility\Hash;

/**
 * Class Plugin
 *
 * Created by allancarvalho in abril 17, 2020
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
		foreach (Configure::read('DataTables.Cache') as $cacheConfigName => $cacheConfig) {
			if (empty(Cache::getConfig($cacheConfigName))) {
				Cache::setConfig($cacheConfigName, $cacheConfig);
			}
		}
	}

}
