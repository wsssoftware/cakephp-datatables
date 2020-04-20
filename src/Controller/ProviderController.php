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
use Cake\I18n\Time;
use Cake\View\JsonView;
use DataTables\Table\Builder;

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
		$this->_configBundle = Builder::getInstance()
		                       ->getConfigBundle("$tablesCass::$configBundle", $this->_cache);

		$result = [
			'draw' => $this->getData('draw', 1),
			'recordsTotal' => 100,
			'recordsFiltered' => 100,
			'data' => [
				[
					111,
					'Allan Carvalho',
					h(Time::now()->modify('-30 days')),
					h(Time::now()->modify('-2 months')),
					'',
				],
			],
		];
		$this->viewBuilder()->setClassName(JsonView::class);
		$this->set(compact('result'));
	}

	/**
	 * @param string|null $name
	 * @param mixed $default
	 * @return mixed
	 */
	private function getData(?string $name = null, $default = null) {
		if ($this->_configBundle->Options->Ajax->getRequestType() === 'POST') {
			$this->getRequest()->getData($name, $default);
		}
		return $this->getRequest()->getQuery($name, $default);
	}

}
