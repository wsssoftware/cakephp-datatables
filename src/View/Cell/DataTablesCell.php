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

namespace DataTables\View\Cell;

use Cake\View\Cell;
use DataTables\Table\Columns;

/**
 * Class DataTablesCell
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class DataTablesCell extends Cell {

	/**
	 * Method that return the table html structure.
	 *
	 * @param \DataTables\Table\Columns $columns Config that is a concatenation of Tables class and config method.
	 * @return void
	 */
	public function table(Columns $columns): void {

	}

}
