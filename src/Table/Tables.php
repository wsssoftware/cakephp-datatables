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

namespace DataTables\Table;

use Cake\Error\FatalErrorException;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * Class Tables
 *
 * Created by allancarvalho in abril 17, 2020
 */
abstract class Tables {

	/**
	 * The database table name that will be used to load the DataTables ORM table.
	 *
	 * @var string
	 */
	protected $_ormTableName;

	/**
	 * Tables constructor.
	 */
	public function __construct() {
		$className = get_called_class();
		$classShortName = explode('\\', get_called_class());
		$classShortName = array_pop($classShortName);
		if (substr($classShortName, -6, 6) !== 'Tables') {
			throw new FatalErrorException("The class '$className' must have the name ending with 'Tables'");
		}
		if (empty($this->_ormTableName)) {
			$this->_ormTableName = substr_replace($classShortName, '', -6, 6);
		}
	}

	/**
	 * @return \Cake\ORM\Table
	 */
	public function getOrmTable(): Table {
		return TableRegistry::getTableLocator()->get($this->_ormTableName);
	}

}
