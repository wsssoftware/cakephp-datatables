<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use DataTables\Table\Builder;
use DataTables\Tools\Functions;
use DataTables\View\DataTablesView;

/**
 * Class ProviderController
 * Created by allancarvalho in abril 17, 2020
 *
 * @property \DataTables\Controller\Component\DataTablesComponent $DataTables
 */
class ProviderController extends AppController {

	/**
	 * @var bool
	 */
	private $_cache = true;

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	private $_configBundle;

	/**
	 * @inheritDoc
	 * @throws \Exception
	 */
	public function initialize(): void {
		parent::initialize();
		$this->loadComponent('DataTables.DataTables');
	}

	/**
	 * @inheritDoc
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
		if (Configure::read('debug') === false) {
			$this->getRequest()->allowMethod(['POST', 'GET']);
		}
		$forceCache = (bool)Configure::read('DataTables.StorageEngine.forceCache');
		if (Configure::read('debug') === true && $forceCache === false) {
			$this->_cache = false;
		}
	}

	/**
	 * Index method
	 *
	 * @param string $tablesCass
	 * @param string $configBundle
	 * @param string|null $urlMd5
	 * @return \Cake\Http\Response|null|void Renders view
	 * @throws \ReflectionException
	 */
	public function getTablesData(string $tablesCass, string $configBundle, string $urlMd5 = null) {
		$this->_configBundle = Builder::getInstance()->getConfigBundle(Inflector::camelize($tablesCass), $this->_cache);
		$pageSize = (int)$this->getData('length');
		$page = (int)($this->getData('start') + $pageSize) / $pageSize;
		$find = $this->getFind()->page($page, $pageSize);
		$data = $find->toArray();
		$result = [
			'draw' => $this->getData('draw', 1),
			'recordsTotal' => $find->count(),
			'recordsFiltered' => $find->count(),
			'data' => [],
		];
		if ((bool)$this->getData('debug')) {
			$result = $this->getData();
		}
		$this->viewBuilder()->setClassName(DataTablesView::class);
		$configBundle = $this->_configBundle;
		$this->set(compact('result', 'data', 'configBundle'));
	}

	/**
	 * @param string|null $name
	 * @param mixed $default
	 * @return mixed
	 */
	private function getData(?string $name = null, $default = null) {
		if ($this->_configBundle->Options->getAjaxRequestType() === 'POST') {
			return $this->getRequest()->getData($name, $default);
		}

		return $this->getRequest()->getQuery($name, $default);
	}

	/**
	 * @return \Cake\ORM\Query
	 */
	private function getFind(): Query {
		$select = [];
		$contains = [];
		$columns = $this->_configBundle->Columns;
		$table = $columns->getDataTables()->getOrmTable();
		$query = $this->_configBundle->Query->mergeWithQuery($table->find());
		foreach ($columns->getColumns() as $columnName => $column) {
			if ($column->isDatabase() && !Functions::getInstance()->getAssociationUsingPath($table, $column->getAssociationPath()) instanceof HasMany) {
				$select[] = $columnName;
			}
			$associationPaths = substr_replace($column->getAssociationPath(), '', 0, strlen($table->getAlias()) + 1);
			if (!empty($associationPaths)) {
				$contains = Hash::merge($contains, Hash::insert([], $associationPaths, []));
			}
		}
		foreach ($this->getData('order', []) as $order) {
			$databaseColumn = $columns->getColumnNameByIndex((int)$order['column']);
			if ($order['dir'] === 'asc') {
				$query->orderAsc($databaseColumn);
			} elseif ($order['dir'] === 'desc') {
				$query->orderDesc($databaseColumn);
			}
		}
		$this->doSearch($query);
		return $query->contain($contains)->select($select);
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
			$conditions += ["CONVERT($databaseColumn,char) LIKE" => "%$searchValue%"];
			if ($searchRegex === true && Functions::getInstance()->checkRegexFormat($searchValue)) {
				$conditions += ["CONVERT($databaseColumn,char) REGEXP" => "$searchValue"];
			}
		}
	}

}
