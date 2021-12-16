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

use Cake\Http\ServerRequest;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\Utility\Hash;
use DataTables\Tools\Functions;

/**
 * Class AjaxData
 * Created by allancarvalho in maio 02, 2020
 */
final class TableDataUtils {

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	private $_configBundle;

	/**
	 * @var \Cake\Http\ServerRequest
	 */
	private $_request;

	/**
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @param \Cake\Http\ServerRequest $request
	 */
	public function __construct(ConfigBundle $configBundle, ServerRequest $request) {
		$this->_configBundle = $configBundle;
		$this->_request = $request;
	}

	/**
	 * @param string|null $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getData(?string $name = null, $default = null) {
		if ($this->_configBundle->Options->getAjaxRequestType() === 'POST') {
			return $this->_request->getData($name, $default);
		}

		return $this->_request->getQuery($name, $default);
	}

	/**
	 * @return \Cake\ORM\Query
	 */
	public function getFind(): Query {
		$select = [];
		$contains = [];
		$columns = $this->_configBundle->Columns;
		$table = $this->_configBundle->getDataTables()->getOrmTable();
		$query = $this->_configBundle->Query->mergeWithQuery($table->find());
		foreach ($columns->getColumns() as $columnName => $column) {
			if ($column->isDatabase() && empty($column->getFunctionExpression()) && !Functions::getInstance()->getAssociationUsingPath($table, $column->getAssociationPath()) instanceof HasMany) {
				$select[] = $columnName;
			} elseif (!empty($column->getFunctionExpression())) {
				$select[$columnName] = $column->getFunctionExpression();
			}
			$associationPaths = substr_replace($column->getAssociationPath(), '', 0, strlen($table->getAlias()) + 1);
			if (!empty($associationPaths)) {
				$contains = Hash::merge($contains, Hash::insert([], $associationPaths, []));
			}
		}
		$this->setOrders($query, $columns);
		$this->doSearch($query);
		$pageSize = (int)$this->getData('length');
		$page = (int)($this->getData('start') + $pageSize) / $pageSize;

		return $query
			->contain($contains)
			->select($select)
			->page($page, $pageSize);
	}

	/**
	 * Set the table columns order
	 *
	 * @param \Cake\ORM\Query $query
	 * @param \DataTables\Table\Columns $columns
	 * @return void
	 */
	private function setOrders(Query $query, Columns $columns): void {
		foreach ($this->getData('order', []) as $order) {
			$databaseColumn = $columns->getColumnNameByIndex((int)$order['column']);
			if ($order['dir'] === 'asc') {
				$query->orderAsc($databaseColumn);
			} elseif ($order['dir'] === 'desc') {
				$query->orderDesc($databaseColumn);
			}
		}
	}

	/**
	 * @param \Cake\ORM\Query $query
	 * @return void
	 */
	private function doSearch(Query $query): void {
		$orWhere = [];
		$columnOrWhere = [];
		$searchValue = $this->getData('search.value', null);
		$searchRegex = filter_var($this->getData('search.regex', false), FILTER_VALIDATE_BOOLEAN);
		foreach ($this->getData('columns') as $column) {
			if (filter_var($column['searchable'], FILTER_VALIDATE_BOOLEAN) === true) {
				$databaseColumn = $this->_configBundle->Columns->getColumnNameByIndex((int)$column['data']);
				$this->insertSearchInArray($orWhere, $databaseColumn, $searchValue, $searchRegex);
				$columnSearchValue = Hash::get($column, 'search.value', null);
				$columnSearchRegex = filter_var(Hash::get($column, 'search.regex', false), FILTER_VALIDATE_BOOLEAN);
				$this->insertSearchInArray($columnOrWhere, $databaseColumn, $columnSearchValue, $columnSearchRegex);
			}
		}
		$query->where(['OR' => $orWhere]);
		$query->where(['OR' => $columnOrWhere]);
	}

	/**
	 * @param array $conditions
	 * @param string $databaseColumn
	 * @param string $searchValue
	 * @param bool $searchRegex
	 * @return void
	 */
	private function insertSearchInArray(array &$conditions, string $databaseColumn, string $searchValue, bool $searchRegex): void {
		if (!empty($searchValue)) {
			$databaseColumn = ConnectionManager::get('default')->getDriver()->quoteIdentifier($databaseColumn);
			$conditions += ["CONVERT($databaseColumn,char) LIKE" => "%$searchValue%"];
			if ($searchRegex === true && Functions::getInstance()->checkRegexFormat($searchValue)) {
				$conditions += ["CONVERT($databaseColumn,char) REGEXP" => "$searchValue"];
			}
		}
	}

}
