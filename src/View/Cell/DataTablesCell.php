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
declare(strict_types = 1);

namespace DataTables\View\Cell;

use Cake\View\Cell;
use DataTables\Table\Columns;

/**
 * DataTables cell
 */
class DataTablesCell extends Cell {

    /**
     * Method that return the table html structure.
     *
     * @param Columns $columns Config that is a concatenation of Tables class and config method.
     * @return void.
     */
	public function table(Columns $columns): void {

	}

}
