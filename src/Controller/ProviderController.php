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
	 * @return void
	 */
	public function getI18nTranslation() {
		$json = [
			'oAria' => [
				'sSortAscending' => __d('data_tables', '{0} activate to sort column ascending', ':'),
				'sSortDescending' => __d('data_tables', '{0} activate to sort column descending', ':'),
			],
			'sEmptyTable' => __d('data_tables', 'No data available in table'),
			'sDecimal' => __d('data_tables', '.'),
			'sInfo' => __d('data_tables', 'Showing {0} to {1} of {2} entries', '_START_', '_END_', '_TOTAL_'),
			'sInfoEmpty' => __d('data_tables', 'Showing {0} to {1} of {2} entries', '0', '0', '0'),
			'sInfoFiltered' => '(' . __d('data_tables', 'filtered from {0} total entries', '_MAX_') . ')',
			'sLengthMenu' => __d('data_tables', 'Show {0} entries', '_MENU_'),
			'sLoadingRecords' => __d('data_tables', 'Loading') . '...',
			'oPaginate' => [
				'sNext' => __d('data_tables', 'Next'),
				'sPrevious' => __d('data_tables', 'Previous'),
				'sFirst' => __d('data_tables', 'First'),
				'sLast' => __d('data_tables', 'Last'),
			],
			'sProcessing' => __d('data_tables', 'Processing') . '...',
			'sSearch' => __d('data_tables', 'Search:'),
			'sSearchPlaceholder' => __d('data_tables', 'Search records'),
			'sThousands' => __d('data_tables', ','),
			'sZeroRecords' => __d('data_tables', 'No matching records found'),
			'oAutoFill' => [
				'sButton' => __d('data_tables', 'Go!'),
				'sCancel' => __d('data_tables', 'Cancel'),
				'sFill' => __d('data_tables', 'Fill all cells with {0}', '>i<{data}>/i<'),
				'sFillHorizontal' => __d('data_tables', 'Fill cells horizontally'),
				'sFillVertical' => __d('data_tables', 'Fill cells vertically'),
				'sIncrement' => __d('data_tables', 'Increment / decrement each cell by: {0}', '>input type=\'number\' value=\'1\'<'),
				'sInfo' => __d('data_tables', 'Select a data fill type:'),
			],
			'oButtons' => [
				'sCopy' => __d('data_tables', 'Copy'),
				'sColvis' => __d('data_tables', 'Visibility'),
			],
			'oSelect' => [
				'sRows' => [
					'_' => __d('data_tables', 'Selected {0} cells', '%d'),
					'0' => __d('data_tables', 'Click a cell to select it'),
					'1' => __d('data_tables', 'Selected 1 cell'),
				],
			],
			'oSearchPanes' => [
				'sCount' => __d('data_tables', '{0} found', '{total}'),
				'sCountFiltered' => __d('data_tables', '{0} ({1})', '{shown}', '{total}'),
				'sEmptyPanes' => __d('data_tables', 'No searchPanes'),
				'sTitle' => [
					'_' => __d('data_tables', 'Filters Selected - {0}', '%d'),
					'0' => __d('data_tables', 'No Filters Selected'),
					'1' => __d('data_tables', 'One Filter Selected'),
				],
			],
		];
		$this->viewBuilder()->setClassName(DataTablesView::class);
		$this->set(compact('json'));
		$this->set('_serialize', 'json');
	}

	/**
	 * Index method
	 *
	 * @param string $tablesCass
	 * @return \Cake\Http\Response|null|void Renders view
	 * @throws \ReflectionException
	 * @noinspection PhpUnused
	 */
	public function getTablesData(string $tablesCass) {
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
