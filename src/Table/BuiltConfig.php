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


use Cake\ORM\Query;

class BuiltConfig
{

    /**
     * @var string The DataTables tables class md5 used to check changes.
     */
    private $_tablesClassMd5;

    /**
     * @var string The DataTables config table html.
     */
    private $_tableHtml;

    /**
     * @var Query The DataTables query state.
     */
    private $_queryBaseState;

    /**
     * @var Columns The DataTables table columns.
     */
    private $_columns;

    /**
     * @var JsOptions The DataTables JS Options.
     */
    private $_jsOptions;

    /**
     * BuiltConfig constructor.
     *
     * @param string $tablesClassMd5 The DataTables tables class md5 used to check changes.
     * @param string $_tableHtml The DataTables config table html.
     * @param QueryBaseState $queryBaseState The DataTables base query.
     * @param Columns $_columns The DataTables table columns.
     * @param JsOptions $jsOptions The DataTables JS Options.
     */
    public function __construct(string $tablesClassMd5, string $_tableHtml, QueryBaseState $queryBaseState, Columns $_columns, JsOptions $jsOptions)
    {
        $this->_tablesClassMd5 = $tablesClassMd5;
        $this->_tableHtml = $_tableHtml;
        $this->_queryBaseState = $queryBaseState;
        $this->_columns = $_columns;
        $this->_jsOptions = $jsOptions;
    }

    /**
     * @return string
     */
    public function getTablesClassMd5(): string
    {
        return $this->_tablesClassMd5;
    }

    /**
     * @param string $tablesClassMd5
     */
    public function setTablesClassMd5(string $tablesClassMd5): void
    {
        $this->_tablesClassMd5 = $tablesClassMd5;
    }

    /**
     * @return string
     */
    public function getTableHtml(): string
    {
        return $this->_tableHtml;
    }

    /**
     * @param string $tableHtml
     */
    public function setTableHtml(string $tableHtml): void
    {
        $this->_tableHtml = $tableHtml;
    }

    /**
     * @return QueryBaseState
     */
    public function getQueryBaseState(): QueryBaseState
    {
        return $this->_queryBaseState;
    }

    /**
     * @param QueryBaseState $queryBaseState
     */
    public function setQueryBaseState(QueryBaseState $queryBaseState): void
    {
        $this->_queryBaseState = $queryBaseState;
    }

    /**
     * @return Columns
     */
    public function getColumns(): Columns
    {
        return $this->_columns;
    }

    /**
     * @param Columns $columns
     */
    public function setColumns(Columns $columns): void
    {
        $this->_columns = $columns;
    }

    /**
     * @return JsOptions
     */
    public function getJsOptions(): JsOptions
    {
        return $this->_jsOptions;
    }

    /**
     * @param JsOptions $jsOptions
     */
    public function setJsOptions(JsOptions $jsOptions): void
    {
        $this->_jsOptions = $jsOptions;
    }


}
