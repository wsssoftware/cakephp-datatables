<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use DataTables\Tools\Builder;

/**
 * Class DataTablesHelper
 *
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
	];

	/**
	 * @inheritDoc
	 */
	public function initialize(array $config): void {
		parent::initialize($config);
		if (Configure::read('debug') === true) {
			$this->setConfig('cache', !(bool)Configure::read('DataTables.StorageEngine.disableWhenDebugOn'));
		}
	}

	/**
	 * Render the table html structure of a DataTables configure.
	 *
	 * @param string $table A Tables class plus config method that you want to render concatenated by '::'. Eg.: 'Foo::main'.
	 * @return string
	 * @throws \ReflectionException
	 */
	public function renderTable(string $table): string {
		$configBundle = Builder::getInstance()->getConfigBundle($table, $this->getConfig('cache'));
		return $configBundle->generateTableHtml($this->getView());
	}

}
