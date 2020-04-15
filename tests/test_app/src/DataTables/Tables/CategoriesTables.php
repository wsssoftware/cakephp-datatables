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

namespace TestApp\DataTables\Tables;

use DataTables\Option\MainOption;
use DataTables\Table\Columns;
use DataTables\Table\QueryBaseState;
use DataTables\Table\Tables;

/**
 * Class CategoriesTables
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class CategoriesTables extends Tables {

	/**
	 * @var string
	 */
	protected $_ormTableName = 'Categories';

	/**
	 * @param \DataTables\Table\QueryBaseState $queryBaseState
	 * @param \DataTables\Table\Columns $columns
	 * @param \DataTables\Option\MainOption $option
	 * @return void
	 */
	public function mainConfig(QueryBaseState $queryBaseState, Columns $columns, MainOption $option): void {

	}

}
