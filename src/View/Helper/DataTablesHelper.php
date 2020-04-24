<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\View\Helper;

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\View\Helper;
use DataTables\Table\Builder;
use DataTables\Table\ResourcesConfig\LocalResourceConfig;

/**
 * Class DataTablesHelper
 * Created by allancarvalho in abril 17, 2020
 */
class DataTablesHelper extends Helper {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [
		'cache' => true,
		'minify' => true,
		'autoLoadLibraries' => true,
	];

	/**
	 * @var bool
	 */
	private $_isLoaded = false;

	/**
	 * @var \DataTables\Table\ConfigBundle[]
	 */
	protected $_configBundles = [];

	/**
	 * @inheritDoc
	 */
	public function initialize(array $config): void {
		parent::initialize($config);
		$this->setConfig('autoLoadLibraries', Configure::read('DataTables.autoLoadLibraries'));
		$forceCache = (bool)Configure::read('DataTables.StorageEngine.forceCache');
		if (Configure::read('debug') === true && $forceCache === false) {
			$this->setConfig('cache', false);
		}
		$this->setConfig($config);
		EventManager::instance()->on('View.beforeLayout', function ()
		{
			if (!empty($this->_configBundles)) {
				$this->getLocalResourceConfig()->requestLoad($this->getView());
			}
		});

	}

	/**
	 * Render the table html structure of a DataTables configure.
	 *
	 * @param string $dataTables DataTables class FQN or name.
	 * @param array $options A table tag options.
	 * @return string
	 * @throws \ReflectionException
	 */
	public function renderTable(string $dataTables, array $options = []): string {
		$configBundle = Builder::getInstance()->getConfigBundle($dataTables, $this->getConfig('cache'));
		$this->_configBundles[$configBundle->getUniqueId()] = $configBundle;

		return $configBundle->generateTableHtml($this->getView(), $options);
	}

	/**
	 * @return \DataTables\Table\ResourcesConfig\LocalResourceConfig
	 */
	public function getLocalResourceConfig() {
		return LocalResourceConfig::getInstance();
	}

	/**
	 * Render all configBundles called.
	 *
	 * @return string
	 */
	public function renderJs(): string {
		$result = '';
		if (!empty($this->_configBundles)) {
			$result .= $this->getView()->element('DataTables.script', ['configBundles' => $this->_configBundles]);
		}
		return $result;
	}

}
