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
		$this->_configBundle = Builder::getInstance()->getConfigBundle("$tablesCass::$configBundle", $this->_cache);
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
		if ($this->_configBundle->Options->Ajax->getRequestType() === 'POST') {
			return $this->getRequest()->getData($name, $default);
		}

		return $this->getRequest()->getQuery($name, $default);
	}

	/**
	 * @return \Cake\ORM\Query
	 */
	private function getFind(): Query {
		$query = $this->_configBundle->Columns->getTables()->getOrmTable()->find();
		$columns = $this->_configBundle->Columns;
		$this->_configBundle->Query->mergeWithQuery($query);
		$select = [];
		$contains = [];
		foreach ($columns->getColumns() as $columnName => $column) {
			if (count(explode('.', $columnName)) === 2) {
				$association = Functions::getInstance()->getAssociationUsingPath($columns->getTables()->getOrmTable(), $column->getAssociationPath());
				if (!$association instanceof HasMany) {
					$select[] = $columnName;
				}
			}
			$associationPaths = substr_replace($column->getAssociationPath(), '', 0, strlen($columns->getTables()->getOrmTable()->getAlias()) + 1);
			if (!empty($associationPaths)) {
				$containArray = Hash::insert([], $associationPaths, []);
				$contains = Hash::merge($contains, $containArray);
			}
		}
		$query->contain($contains);
		$query->select($select);
		$orders = $this->getData('order', []);
		foreach ($orders as $order) {
			$databaseColumn = $columns->getColumnNameByIndex((int)$order['column']);
			if ($order['dir'] === 'asc') {
				$query->orderAsc($databaseColumn);
			} elseif ($order['dir'] === 'desc') {
				$query->orderDesc($databaseColumn);
			}
		}
		$this->doSearch($query);
		return $query;
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
				if (!empty($searchValue)) {
					$orWhere += ["CONVERT($databaseColumn,char) LIKE" => "%$searchValue%"];
					if ($searchRegex === true && Functions::getInstance()->checkRegexFormat($searchValue)) {
						$orWhere += ["CONVERT($databaseColumn,char) REGEXP" => "$searchValue"];
					}
				}
				$columnSearchValue = Hash::get($column, 'search.value', null);
				$columnSearchRegex = filter_var(Hash::get($column, 'search.regex', false), FILTER_VALIDATE_BOOLEAN);
				if (!empty($columnSearchValue)) {
					$columnOrWhere += ["CONVERT($databaseColumn,char) LIKE" => "%$columnSearchValue%"];
					if ($columnSearchRegex === true && Functions::getInstance()->checkRegexFormat($columnSearchValue)) {
						$columnOrWhere += ["CONVERT($databaseColumn,char) REGEXP" => "$columnSearchValue"];
					}
				}
			}
		}
		$query->where(['OR' => $orWhere]);
		$query->where(['OR' => $columnOrWhere]);
	}

}
