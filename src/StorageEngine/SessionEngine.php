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

namespace DataTables\StorageEngine;

use Cake\Http\Session;
use Cake\Routing\Router;
use DataTables\Table\BuiltConfig;

class SessionEngine implements StorageEngineInterface {

	/**
	 * @var Session|null
	 */
	private $session = null;

    /**
     * SessionEngine constructor.
     */
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
	public function save(string $key, BuiltConfig $builtConfig): bool {
		$this->session->write("DataTables.builtConfigs.$key", $builtConfig);

		return $this->session->check("DataTables.builtConfigs.$key");
	}

	/**
	 * @inheritDoc
	 */
	public function exists(string $key): bool {
		return $this->session->check("DataTables.builtConfigs.$key");
	}

	/**
	 * @inheritDoc
	 */
	public function read(string $key): ?BuiltConfig {
		/** @var BuiltConfig|null $tableConfig */
		$tableConfig = $this->session->read("DataTables.builtConfigs.$key");

		return ($tableConfig instanceof BuiltConfig) ? $tableConfig : null;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(string $key): bool {
	    $this->session->delete("DataTables.builtConfigs.$key");

		return !$this->session->check("DataTables.builtConfigs.$key");
	}

}
