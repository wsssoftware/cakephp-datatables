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

namespace DataTables\Table;

use Cake\View\View;
use DataTables\Table\Option\MainOption;

/**
 * Class ConfigBundle
 * Created by allancarvalho in abril 17, 2020
 */
final class ConfigBundle {

	/**
	 * @var string
	 */
	private $_tableCass;

	/**
	 * @var string
	 */
	private $_configMethod;

	/**
	 * @var \DataTables\Table\Columns The DataTables table columns.
	 */
	public $Columns;

	/**
	 * @var \DataTables\Table\Option\MainOption The DataTables JS Options.
	 */
	public $Options;

	/**
	 * @var \DataTables\Table\QueryBaseState The DataTables query state.
	 */
	public $Query;

	/**
	 * @var string The md5 used to check changes.
	 */
	private $_checkMd5;

	/**
	 * ConfigBundle constructor.
	 *
	 * @param string $checkMd5 The md5 used to check changes.
	 * @param \DataTables\Table\Columns $columns The DataTables table columns.
	 * @param \DataTables\Table\Option\MainOption $options The DataTables JS Options.
	 * @param \DataTables\Table\QueryBaseState $query The DataTables base query.
	 * @param string $tableCass Tables class name.
	 * @param string $_configMethod Config method from tables class.
	 */
	public function __construct(
		string $checkMd5,
		Columns $columns,
		MainOption $options,
		QueryBaseState $query,
		string $tableCass,
		string $_configMethod
	) {
		$this->_checkMd5 = $checkMd5;
		$this->Columns = $columns;
		$this->Options = $options;
		$this->Query = $query;
		$this->_tableCass = $tableCass;
		$this->_configMethod = $_configMethod;
	}

	/**
	 * @return mixed
	 */
	public function getTableCass() {
		return $this->_tableCass;
	}

	/**
	 * @return string
	 */
	public function getConfigMethod(): string {
		return $this->_configMethod;
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
	 * @param array $options
	 * @return string
	 */
	public function generateTableHtml(View $view, array $options = []): string {
		return $view->cell('DataTables.DataTables::table', [$this, $options])->render();
	}

}
