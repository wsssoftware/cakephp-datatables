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

namespace DataTables\Table;


abstract class Tables
{
    /**
     * The main database table name that will be used to create the DataTables table.
     *
     * @var string
     */
    protected $_ormTable;

    public function __construct()
    {
        if (empty($this->_ormTable)) {

        }
    }
}
