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

namespace DataTables\Builder;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use DataTables\Table\Columns;
use DataTables\Table\JsOptions;
use DataTables\Table\Tables;

class Builder {

	public function buildTables(string $tablesClass, string $config): Tables {
		/** @var \DataTables\Table\Tables $tables */
		$tables = null;
		$classWithNameSpace = null;
		if(class_exists($tablesClass)) {
			$classWithNameSpace = $tablesClass;
		} elseif(file_exists(APP . 'DataTables' . DS . 'Tables' . DS . $tablesClass . 'Tables.php')) {
			$classWithNameSpace = Configure::read('App.namespace') . '\\DataTables\\Tables\\' . $tablesClass . 'Tables';
		}
		if(!empty($classWithNameSpace)) {
			$tables = new $classWithNameSpace();
		}
		if(empty($tables)){
			throw new FatalErrorException("Tables class '$tablesClass' not found.");
		}
		if(!method_exists($tables, $config . 'Config')) {
			throw new FatalErrorException("Config method '{$config}Config' don't exist in '$classWithNameSpace'.");
		}

		return $tables;
	}

	public function buildQuery(Tables $table) {
		return $table->getOrmTable()->find();
	}

	public function buildColumns(Tables $table): Columns {
		return new Columns();
	}

	public function buildJsOptions(Tables $table): JsOptions {
		return new JsOptions();
	}

}
