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

return [
	'DataTables' => [
		'StorageEngine' => [
			'class' => \DataTables\StorageEngine\CacheStorageEngine::class,
			'disableWhenDebugOn' => true,
			'cacheStorageEngineConfig' => [
				'className' => \Cake\Cache\Engine\FileEngine::class,
				'prefix' => 'built_config_',
				'path' => CACHE . DS . 'data_tables' . DS . 'built_configs' . DS,
				'serialize' => true,
				'duration' => '+30 days',
				'url' => env('CACHE_CAKECORE_URL', null),
			],
		],
		'resources' => [
			'callbacksFolder' => ROOT . DS . 'templates' . DS . 'DataTables' . DS . 'Callbacks' . DS,
			'callbacksCacheFolder' => CACHE . DS . 'data_tables' . DS . 'twig' . DS,
		],
	],
];
