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
	 * @var \DataTables\Table\Columns The DataTables table columns.
	 */
	public $Columns;

	/**
	 * @var \DataTables\Table\CustomRotesConfig The DataTables table custom rotes config.
	 */
	public $CustomRotesConfigs;

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
	 * @param \DataTables\Table\CustomRotesConfig $customRotesConfig
	 * @param \DataTables\Table\Columns $columns The DataTables table columns.
	 * @param \DataTables\Table\Option\MainOption $options The DataTables JS Options.
	 * @param \DataTables\Table\QueryBaseState $query The DataTables base query.
	 */
	public function __construct(
		string $checkMd5,
		CustomRotesConfig $customRotesConfig,
		Columns $columns,
		MainOption $options,
		QueryBaseState $query
	) {
		$this->_checkMd5 = $checkMd5;
		$this->CustomRotesConfigs = $customRotesConfig;
		$this->Columns = $columns;
		$this->Options = $options;
		$this->Query = $query;
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
