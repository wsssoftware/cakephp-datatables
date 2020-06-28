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

/**
 * Test suite bootstrap for DataTables.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
$findRoot = function ($root) {
	do {
		$lastRoot = $root;
		$root = dirname($root);
		if (is_dir($root . '/vendor/cakephp/cakephp')) {
			return $root;
		}
	} while ($root !== $lastRoot);

	throw new Exception('Cannot find the root of the application, unable to run tests');
};
$root = $findRoot(__FILE__);
unset($findRoot);
if (file_exists($root . DS . 'config' . DS . 'paths.php')) {
	require_once $root . DS . 'config' . DS . 'paths.php';
}

chdir($root);
require_once $root . '/vendor/autoload.php';

/**
 * Define fallback values for required constants and configuration.
 * To customize constants and configuration remove this require
 * and define the data required by your plugin here.
 */
require_once $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';

Cake\Core\Configure::write('App.namespace', 'TestApp');

class_alias(TestApp\Controller\AppController::class, 'App\Controller\AppController');
class_alias(TestApp\DataTables\CategoriesDataTables::class, 'App\DataTables\CategoriesTables');
class_alias(TestApp\DataTables\AppDataTables::class, 'App\DataTables\AppDataTables');

if (file_exists($root . '/config/bootstrap.php')) {
	require $root . '/config/bootstrap.php';

	return;
}
