<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

use Cake\Error\FatalErrorException;
use Cake\View\View;
use DataTables\Tools\Validator;

/**
 * Class UrlQueryBuilder
 * Created by allancarvalho in maio 20, 2020
 */
class UrlQueryBuilder {

	/**
	 * @var \Cake\View\View
	 */
	private $_view;

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	private $_configBundle;

	/**
	 * @var string
	 */
	private $_name;

	/**
	 * @var array
	 */
	private $_url;

	/**
	 * @var array
	 */
	private $_options;

	/**
	 * @var array
	 */
	private $_originalQuery = [];

	/**
	 * @var array
	 */
	private $_query = [];

	/**
	 * @param \Cake\View\View $view
	 * @param string $dataTables DataTables config name or FQN.
	 * @param string $name
	 * @param array $url
	 * @param array $options
	 * @throws \ReflectionException
	 */
	public function __construct(View $view, string $dataTables, string $name, array $url, array $options) {
		$this->_view = $view;
		$this->_configBundle = Builder::getInstance()->getConfigBundle($dataTables);
		$this->_name = $name;
		$this->_url = $url;
		if (!empty($this->_url['?'])) {
			$this->_originalQuery = $this->_url['?'];
			unset($this->_url['?']);
		}
		$this->_options = $options;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$query = $this->_originalQuery;
		$query += [
			'data-tables' => [
				$this->_configBundle->getDataTables()->getAlias() => $this->_query,
			],
		];
		$this->_url['?'] = $query;

		return $this->_view->Html->link($this->_name, $this->_url, $this->_options);
	}

	/**
	 * Set the order for column Asc
	 *
	 * @param string $dataBaseField
	 * @return $this
	 */
	public function setColumnOrderAsc(string $dataBaseField) {
		$columnInfo = $this->_configBundle->Columns->normalizeDataTableField($dataBaseField);
		$dataBaseField = $columnInfo['table'] . '.' . $columnInfo['column'];
		$this->_query['columns'][$dataBaseField]['order'] = 'asc';

		return $this;
	}

	/**
	 * Set the order for column Desc
	 *
	 * @param string $dataBaseField
	 * @return $this
	 */
	public function setColumnOrderDesc(string $dataBaseField) {
		$columnInfo = $this->_configBundle->Columns->normalizeDataTableField($dataBaseField);
		$dataBaseField = $columnInfo['table'] . '.' . $columnInfo['column'];
		$this->_query['columns'][$dataBaseField]['order'] = 'desc';

		return $this;
	}

	/**
	 * Set the search for a column
	 *
	 * @param string $dataBaseField
	 * @param string $search
	 * @return $this
	 */
	public function setColumnSearch(string $dataBaseField, string $search) {
		$columnInfo = $this->_configBundle->Columns->normalizeDataTableField($dataBaseField);
		$dataBaseField = $columnInfo['table'] . '.' . $columnInfo['column'];
		$this->_query['columns'][$dataBaseField]['search'] = $search;

		return $this;
	}

	/**
	 * Set table current page.
	 *
	 * @param string|int $page
	 * @return $this
	 */
	public function setPage($page) {
		if (is_string($page)) {
			Validator::getInstance()->inArrayOrFail($page, ['first', 'next', 'previous', 'last']);
		} elseif (!is_int($page)) {
			throw new FatalErrorException('Invalid type of page. Must be int or string');
		}
		$this->_query['page'] = $page;

		return $this;
	}

	/**
	 * Set table search value.
	 *
	 * @param string $search
	 * @return $this
	 */
	public function setSearch(string $search) {
		$this->_query['search'] = $search;

		return $this;
	}

}
