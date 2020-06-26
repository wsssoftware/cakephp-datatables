<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace TestApp\DataTables;

use DataTables\Table\ConfigBundle;
use DataTables\Table\DataTables;

/**
 * Class CategoriesTables
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class CategoriesDataTables extends DataTables {

	/**
	 * @var string
	 */
	protected $_ormTableName = 'Categories';

	/**
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @return void
	 */
	public function config(ConfigBundle $configBundle): void {
		parent::config($configBundle);
		$configBundle->Columns->addDatabaseColumn('Categories.id');
		$configBundle->Columns->addDatabaseColumn('Categories.name');
		$configBundle->Columns->addDatabaseColumn('Categories.created');
	}

}
