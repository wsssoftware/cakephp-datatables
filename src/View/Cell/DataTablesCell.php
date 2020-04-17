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

namespace DataTables\View\Cell;

use Cake\View\Cell;
use DataTables\Table\Columns;

/**
 * Class DataTablesCell
 *
 * Created by allancarvalho in abril 17, 2020
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
