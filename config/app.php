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
		],
		'resources' => [
			'templates' => ROOT . DS . 'templates' . DS . 'data_tables' . DS,
			'twigCacheFolder' => CACHE . DS . 'data_tables' . DS . 'twig' . DS,
		],
		'Cache' => [
			'_data_tables_config_bundles_' => [
				'className' => \Cake\Cache\Engine\FileEngine::class,
				'prefix' => 'built_config_',
				'path' => CACHE . DS . 'data_tables' . DS . 'config_bundles' . DS,
				'serialize' => true,
				'duration' => '+30 days',
				'url' => env('CACHE_CAKECORE_URL', null),
			],
		],
	],
];
