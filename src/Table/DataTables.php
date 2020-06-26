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

use Cake\Datasource\EntityInterface;
use Cake\Error\FatalErrorException;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use DataTables\View\DataTablesView;

/**
 * Class Tables
 *
 * Created by allancarvalho in abril 17, 2020
 */
abstract class DataTables {

	/**
	 * The database table name that will be used to load the DataTables ORM table.
	 *
	 * @var string
	 */
	protected $_ormTableName;

	/**
	 * @var string
	 */
	protected $_alias;

	public function __construct() {
		$className = static::class;
		$classShortName = explode('\\', static::class);
		$classShortName = array_pop($classShortName);
		if (substr($classShortName, -10, 10) !== 'DataTables') {
			throw new FatalErrorException("The class '$className' must have the name ending with 'DataTables'");
		}
		if (empty($this->_ormTableName)) {
			$this->_ormTableName = substr_replace($classShortName, '', -10, 10);
		}
		$this->_alias = substr_replace($classShortName, '', -10, 10);
	}

	/**
	 * @return \Cake\ORM\Table
	 */
	public function getOrmTable(): Table {
		return TableRegistry::getTableLocator()->get($this->_ormTableName);
	}

	/**
	 * @return string
	 */
	public function getAlias(): string {
		return $this->_alias;
	}

	/**
	 * Will implements all the table configuration.
	 *
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @return void
	 */
	public function config(ConfigBundle $configBundle) {
	}

	/**
	 * @param \DataTables\View\DataTablesView $appView
	 * @param \Cake\Datasource\EntityInterface $entity
	 * @param \DataTables\Table\Renderer $renderer
	 * @return void
	 */
	public function rowRenderer(DataTablesView $appView, EntityInterface $entity, Renderer $renderer) {
	}

}
