<?php
/**
 * Copyright (c) Allan Carvalho 2019.
 * Under Mit License
 * php version 7.2
 *
 * @category CakePHP
 * @package  DataRenderer\Core
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-data-renderer/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-data-renderer
 */
declare(strict_types = 1);

namespace DataTables\Table\StorageEngine;

use Cake\Http\Session;
use Cake\Routing\Router;
use DataTables\Table\StorageEngineInterface;
use DataTables\Table\TableScheme;

class SessionEngine implements StorageEngineInterface {

	/**
	 * @var \Cake\Http\Session|null
	 */
	private $session = null;

	public function __construct() {
		if (!empty(Router::getRequest()) && !empty(Router::getRequest()->getSession())) {
			$this->session = Router::getRequest()->getSession();
		} else {
			$this->session = new Session();
		}
	}

	/**
	 * @inheritDoc
	 */
	public function save(TableScheme $config): bool {
		$this->session->write("DataTables.tableConfigs.{$config->getConfigName()}", $config);

		return $this->session->check("DataTables.tableConfigs.{$config->getConfigName()}");
	}

	/**
	 * @inheritDoc
	 */
	public function exists(string $key): bool {
		return $this->session->check("DataTables.tableConfigs.$key");
	}

	/**
	 * @inheritDoc
	 */
	public function read(string $key): ?TableScheme {
		/** @var \DataTables\Table\TableScheme|null $tableConfig */
		$tableConfig = $this->session->read("DataTables.tableConfigs.$key");

		return ($tableConfig instanceof TableScheme) ? $tableConfig : null;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(string $key): bool {
	    $this->session->delete("DataTables.tableConfigs.$key");

		return !$this->session->check("DataTables.tableConfigs.$key");
	}

}
