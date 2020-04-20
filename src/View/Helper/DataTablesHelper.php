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
use Cake\View\Helper;
use DataTables\Table\Builder;

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
	}

	/**
	 * Render the table html structure of a DataTables configure.
	 *
	 * @param string $tablesAndConfig A Tables class plus config method that you want to render concatenated by '::'.
	 *                               Eg.: 'Foo::main'.
	 * @param array $options A table tag options.
	 * @return string
	 * @throws \ReflectionException
	 */
	public function renderTable(string $tablesAndConfig, array $options = []): string {
		$configBundle = Builder::getInstance()->getConfigBundle($tablesAndConfig, $this->getConfig('cache'));
		$this->_configBundles[$configBundle->getUniqueId()] = $configBundle;

		return $configBundle->generateTableHtml($this->getView(), $options);
	}

	/**
	 * Render all configBundles called.
	 *
	 * @return string
	 */
	public function renderJs(): string {
		$result = '';
		if ((bool)$this->setConfig('autoLoadLibraries') === true) {
			//TODO load scripts
		}
		if (!empty($this->_configBundles)) {
			$result .= $this->getView()->element('DataTables.script', ['configBundles' => $this->_configBundles]);
		}

		return $result;
	}

}
