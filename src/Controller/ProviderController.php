<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Utility\Inflector;
use DataTables\Table\Builder;
use DataTables\Table\TableDataUtils;
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
	 * @noinspection PhpUnused
	 * @return void
	 */
	public function getI18nTranslation() {
		$json = [
			'oAria' => [
				'sSortAscending' => __d('data_tables', '{0} activate to sort column ascending', ':'),
				'sSortDescending' => __d('data_tables', '{0} activate to sort column descending', ':'),
			],
			'sEmptyTable' => __d('data_tables', 'No data available in table'),
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
			'sZeroRecords' => __d('data_tables', 'No matching records found'),
			'oAutoFill' => [
				'sCancel' => __d('data_tables', 'Cancel'),
				'sFill' => __d('data_tables', 'Fill all cells with {0}', '>i<{data}>/i<'),
				'sFillHorizontal' => __d('data_tables', 'Fill cells horizontally'),
				'sFillVertical' => __d('data_tables', 'Fill cells vertically'),
				'sIncrement' => __d('data_tables', 'Increment / decrement each cell by: {0}', '>input type=\'number\' value=\'1\'<'),
			],
		];
		$this->viewBuilder()->setClassName(DataTablesView::class);
		$this->set(compact('json'));
		$this->set('_serialize', 'json');
	}

	/**
	 * Index method
	 *
	 * @noinspection PhpUnused
	 * @param string $tablesCass
	 * @throws \ReflectionException
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function getTablesData(string $tablesCass) {
		$configBundle = Builder::getInstance()->getConfigBundle(Inflector::camelize($tablesCass), $this->_cache);
		$tableDataUtils = new TableDataUtils($configBundle, $this->getRequest());
		$find = $tableDataUtils->getFind();
		$data = $find->toArray();
		$result = [
			'draw' => $tableDataUtils->getData('draw', 1),
			'recordsTotal' => $find->count(),
			'recordsFiltered' => $find->count(),
			'data' => [],
		];
		if ((bool)$tableDataUtils->getData('debug')) {
			$result = $tableDataUtils->getData();
		}
		$this->viewBuilder()->setClassName(DataTablesView::class);
		$this->set(compact('result', 'data', 'configBundle'));
	}

}
