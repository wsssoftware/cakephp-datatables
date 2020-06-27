<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('DataTables', ['path' => '/data-tables'], function (RouteBuilder $builder) {
	$builder->connect('/images/*', ['controller' => 'Assets', 'action' => 'images']);
	$builder->fallbacks(DashedRoute::class);
});
