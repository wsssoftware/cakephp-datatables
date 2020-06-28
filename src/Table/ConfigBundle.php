<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

use Cake\Error\FatalErrorException;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
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
	 * @var \DataTables\Table\Option\MainOption The DataTables JS Options.
	 */
	public $Options;

	/**
	 * @var \DataTables\Table\QueryBaseState The DataTables query state.
	 */
	public $Query;

	/**
	 * @var \DataTables\Table\Assets The DataTables Assets manager.
	 */
	public $Assets;

	/**
	 * @var string
	 */
	private $_dataTableFQN;

	/**
	 * A selected Tables class.
	 *
	 * @var \DataTables\Table\DataTables
	 */
	private $_dataTables;

	/**
	 * @var string The md5 used to check changes.
	 */
	private $_checkMd5;

	/**
	 * @param string $checkMd5 The md5 used to check changes.
	 * @param string $dataTablesFQN Tables class name.
	 * @param object $appDataTablesClass The AppDataTables class from application.
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function __construct(
		string $checkMd5,
		string $dataTablesFQN,
		object $appDataTablesClass
	) {
		$this->_checkMd5 = $checkMd5;
		$this->_dataTableFQN = $dataTablesFQN;
		$this->_dataTables = new $dataTablesFQN();
		if (!$this->_dataTables instanceof DataTables) {
			throw new FatalErrorException("Class '$dataTablesFQN' must be an inheritance of 'DataTables'.");
		}
		$this->Columns = new Columns($this);
		$this->Options = new MainOption($this, $this->getUrl());
		$this->Query = new QueryBaseState();
		$this->Assets = Assets::getInstance();
		$this->Options->setColumns($this->Columns);
		$this->_dataTables->config($this);
		if (method_exists($appDataTablesClass, 'mainConfig')) {
			$appDataTablesClass->mainConfig($this->Options, $this->Assets);
		}
	}

	/**
	 * Return the url to get table data.
	 *
	 * @return string
	 */
	private function getUrl(): string {
		return Router::url([
			'controller' => 'Provider',
			'action' => 'getTablesData',
			Inflector::dasherize($this->_dataTables->getAlias()),
			'plugin' => 'DataTables',
			'prefix' => false,
		]);
	}

	/**
	 * @return \DataTables\Table\DataTables
	 */
	public function getDataTables(): DataTables {
		return $this->_dataTables;
	}

	/**
	 * @return mixed
	 */
	public function getDataTableFQN() {
		return $this->_dataTableFQN;
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
