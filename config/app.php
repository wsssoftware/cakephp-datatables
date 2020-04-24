<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

return [
	'DataTables' => [
		'libraries' => [
			'enabled' => true,
			'cssBlock' => 'css',
			'scriptBlock' => 'script',
			'theme' => \DataTables\Table\ResourcesConfig\ResourcesConfigAbstract::THEME_BASE,
			'loadThemeLibrary' => false,
			'jquery' => \DataTables\Table\ResourcesConfig\ResourcesConfigAbstract::JQUERY_NONE,
			'plugins' => [
				'autoFill' => false,
				'buttons' => false,
				'colReorder' => false,
				'fixedColumns' => false,
				'fixedHeader' => false,
				'keyTable' => false,
				'responsive' => false,
				'rowGroup' => false,
				'rowReorder' => false,
				'scroller' => false,
				'searchPanes' => false,
				'select' => false,
			],

		],
		'StorageEngine' => [
			'class' => \DataTables\StorageEngine\CacheStorageEngine::class,
			'forceCache' => false,
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
				'duration' => '+1 year',
				'url' => env('CACHE_CAKECORE_URL', null),
			],
		],
	],
];
