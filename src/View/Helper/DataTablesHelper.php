<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\View\Helper;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use DataTables\Table\BuiltConfig;
use DataTables\Tools\Builder;
use InvalidArgumentException;

/**
 * Class DataTablesHelper
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
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
		$exploded = explode('::', $table);
		if (count($exploded) !== 2) {
			throw new InvalidArgumentException('Table param must be a concatenation of Tables class and config. Eg.: Foo::method.');
		}
		$tablesClass = $exploded[0];
		$configMethod = $exploded[1];
		$tablesClassWithNameSpace = Configure::read('App.namespace') . '\\DataTables\\Tables\\' . $tablesClass . 'Tables';
		$md5 = Builder::getInstance()->getTablesMd5($tablesClassWithNameSpace);
		$cacheKey = Inflector::underscore(str_replace('::', '_', $table));

		$builtConfig = null;
		if ($this->getConfig('cache')) {
			/** @var \DataTables\Table\BuiltConfig $builtConfig */
			$builtConfig = Builder::getInstance()->getStorageEngine()->read($cacheKey);
		}
		if (empty($builtConfig) && !$builtConfig instanceof BuiltConfig) {
			$builtConfig = Builder::getInstance()->buildBuiltConfig($tablesClassWithNameSpace, $configMethod, $this->getView(), $md5);
		}
		if ($this->getConfig('cache') && !Builder::getInstance()->getStorageEngine()->save($cacheKey, $builtConfig)) {
			throw new FatalErrorException('Unable to save the BuiltConfig cache.');
		}

		return $builtConfig->getTableHtml();
	}

}
