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

return [
	'DataTables' => [
        'StorageEngine' => [
            'class' => \DataTables\StorageEngine\CacheStorageEngine::class,
            'duration' => 43200,
            'disableWhenOnDebug' => true
        ]
	],
];
