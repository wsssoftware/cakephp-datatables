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

namespace DataTables\StorageEngine;

use Cake\Routing\Router;
use DataTables\Table\BuiltConfig;

/**
 * Class SessionEngine
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class SessionEngine implements StorageEngineInterface {

	/**
	 * @var \Cake\Http\Session|null
	 */
	private $session = null;

	/**
	 * SessionEngine constructor.
	 */
	public function __construct() {
		$this->session = Router::getRequest()->getSession();
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
		/** @var \DataTables\Table\BuiltConfig|null $tableConfig */
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
