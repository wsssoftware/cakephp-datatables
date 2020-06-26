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

/*
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

/*
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/*
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('DATA_TABLES_ROOT', dirname(__DIR__));

/*
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('DATA_TABLES_APP_DIR', 'src');

/*
 * Path to the application's directory.
 */
define('DATA_TABLES_APP', DATA_TABLES_ROOT . DS . DATA_TABLES_APP_DIR . DS);

/*
 * Path to the config directory.
 */
define('DATA_TABLES_CONFIG', DATA_TABLES_ROOT . DS . 'config' . DS);

/*
 * File path to the templates directory.
 *
 * To derive your templates from your webserver change this to:
 *
 * `define('WWW_ROOT', rtrim($_SERVER['DOCUMENT_ROOT'], DS) . DS);`
 */
define('DATA_TABLES_TEMPLATES', DATA_TABLES_ROOT . DS . 'templates' . DS);

/*
 * File path to the webroot directory.
 *
 * To derive your webroot from your webserver change this to:
 *
 * `define('WWW_ROOT', rtrim($_SERVER['DOCUMENT_ROOT'], DS) . DS);`
 */
define('DATA_TABLES_WWW_ROOT', DATA_TABLES_ROOT . DS . 'webroot' . DS);

/*
 * Path to the tests directory.
 */
define('DATA_TABLES_TESTS', DATA_TABLES_ROOT . DS . 'tests' . DS);
