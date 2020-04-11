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

namespace DataTables\Table;

use DataTables\Js\Options;

/**
 * Class BuiltConfig
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class BuiltConfig {

	/**
	 * @var string The DataTables tables class md5 used to check changes.
	 */
	private $_tablesClassMd5;

	/**
	 * @var string The DataTables config table html.
	 */
	private $_tableHtml;

	/**
	 * @var \DataTables\Table\QueryBaseState The DataTables query state.
	 */
	private $_queryBaseState;

	/**
	 * @var \DataTables\Table\Columns The DataTables table columns.
	 */
	private $_columns;

	/**
	 * @var \DataTables\Js\Options The DataTables JS Options.
	 */
	private $_options;

	/**
	 * BuiltConfig constructor.
	 *
	 * @param string $tablesClassMd5 The DataTables tables class md5 used to check changes.
	 * @param string $_tableHtml The DataTables config table html.
	 * @param \DataTables\Table\QueryBaseState $queryBaseState The DataTables base query.
	 * @param \DataTables\Table\Columns $_columns The DataTables table columns.
	 * @param \DataTables\Js\Options $options The DataTables JS Options.
	 */
	public function __construct(string $tablesClassMd5, string $_tableHtml, QueryBaseState $queryBaseState, Columns $_columns, Options $options) {
		$this->_tablesClassMd5 = $tablesClassMd5;
		$this->_tableHtml = $_tableHtml;
		$this->_queryBaseState = $queryBaseState;
		$this->_columns = $_columns;
		$this->_options = $options;
	}

	/**
	 * @return string
	 */
	public function getTablesClassMd5(): string {
		return $this->_tablesClassMd5;
	}

	/**
	 * @param string $tablesClassMd5
	 * @return void
	 */
	public function setTablesClassMd5(string $tablesClassMd5): void {
		$this->_tablesClassMd5 = $tablesClassMd5;
	}

	/**
	 * @return string
	 */
	public function getTableHtml(): string {
		return $this->_tableHtml;
	}

	/**
	 * @param string $tableHtml
	 * @return void
	 */
	public function setTableHtml(string $tableHtml): void {
		$this->_tableHtml = $tableHtml;
	}

	/**
	 * @return \DataTables\Table\QueryBaseState
	 */
	public function getQueryBaseState(): QueryBaseState {
		return $this->_queryBaseState;
	}

	/**
	 * @param \DataTables\Table\QueryBaseState $queryBaseState
	 * @return void
	 */
	public function setQueryBaseState(QueryBaseState $queryBaseState): void {
		$this->_queryBaseState = $queryBaseState;
	}

	/**
	 * @return \DataTables\Table\Columns
	 */
	public function getColumns(): Columns {
		return $this->_columns;
	}

	/**
	 * @param \DataTables\Table\Columns $columns
	 * @return void
	 */
	public function setColumns(Columns $columns): void {
		$this->_columns = $columns;
	}

	/**
	 * @return \DataTables\Js\Options
	 */
	public function getOptions(): Options {
		return $this->_options;
	}

	/**
	 * @param \DataTables\Js\Options $options
	 * @return void
	 */
	public function setOptions(Options $options): void {
		$this->_options = $options;
	}

}
