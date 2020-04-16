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

use Cake\View\View;
use DataTables\Table\Option\MainOption;

/**
 * Class ConfigBundle
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
final class ConfigBundle {

	/**
	 * @var string The md5 used to check changes.
	 */
	private $_checkMd5;

	/**
	 * @var \DataTables\Table\QueryBaseState The DataTables query state.
	 */
	public $Query;

	/**
	 * @var \DataTables\Table\Columns The DataTables table columns.
	 */
	public $Columns;

	/**
	 * @var \DataTables\Table\Option\MainOption The DataTables JS Options.
	 */
	public $Options;

	/**
	 * ConfigBundle constructor.
	 *
	 * @param string $checkMd5 The md5 used to check changes.
	 * @param \DataTables\Table\QueryBaseState $queryBaseState The DataTables base query.
	 * @param \DataTables\Table\Columns $_columns The DataTables table columns.
	 * @param \DataTables\Table\Option\MainOption $options The DataTables JS Options.
	 */
	public function __construct(string $checkMd5, QueryBaseState $queryBaseState, Columns $_columns, MainOption $options) {
		$this->_checkMd5 = $checkMd5;
		$this->Query = $queryBaseState;
		$this->Columns = $_columns;
		$this->Options = $options;
	}

	/**
	 * @return string
	 */
	public function getCheckMd5(): string {
		return $this->_checkMd5;
	}

	/**
	 * @return string
	 */
	public function getUniqueId(): string {
		return $this->_checkMd5;
	}

	/**
	 * @param \Cake\View\View $view
	 * @return string
	 */
	public function generateTableHtml(View $view): string {
		return $view->cell('DataTables.DataTables::table', [$this->Columns])->render();
	}

}
