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

namespace DataTables\Test\TestCase\TableConfig\Engine;

use Cake\TestSuite\TestCase;
use DataTables\TableConfig\Engine\SessionEngine;
use DataTables\TableConfig\TableConfig;

class SessionEngineTest extends TestCase {

	/**
	 * @var string|null
	 */
	private $randomKeyName = null;

	/**
	 * @var \DataTables\TableConfig\Engine\SessionEngine|null
	 */
	private $sessionEngine = null;

	/**
	 * SessionEngineTest constructor.
	 *
	 * @param string|null $name
	 * @param array $data
	 * @param string $dataName
	 */
	public function __construct($name = null, array $data = [], $dataName = '') {
		parent::__construct($name, $data, $dataName);

		$this->sessionEngine = new SessionEngine();
		$this->randomKeyName = 'table_config_' . str_pad(rand(0, 99999), 5, 0, STR_PAD_LEFT);
	}

	/**
	 * @return void
	 */
	public function testSave() {
		$tableConfig = new TableConfig();
		$tableConfig->setConfigName($this->randomKeyName);
		$this->assertEquals(true, $this->sessionEngine->save($tableConfig));
	}

	/**
	 * @return void
	 */
	public function testCheck() {
	    $tableConfig = new TableConfig();
	    $tableConfig->setConfigName($this->randomKeyName);
		$this->sessionEngine->save($tableConfig);
		$this->assertEquals(true, $this->sessionEngine->exists($this->randomKeyName));
	}

	/**
	 * @return void
	 */
	public function testRead() {
	    $tableConfig = new TableConfig();
	    $tableConfig->setConfigName($this->randomKeyName);
		$this->sessionEngine->save($tableConfig);
		$this->assertInstanceOf(TableConfig::class, $this->sessionEngine->read($this->randomKeyName));
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$tableConfig = new TableConfig();
		$tableConfig->setConfigName($this->randomKeyName);
		$this->sessionEngine->save($tableConfig);
		$exist = $this->sessionEngine->exists($this->randomKeyName);
		$deleted = $this->sessionEngine->delete($this->randomKeyName);
		$this->assertEquals($exist, $deleted);
	}

}
