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
	 * SessionEngineTest constructor.
	 *
	 * @param string|null $name
	 * @param array $data
	 * @param string $dataName
	 */
	public function __construct($name = null, array $data = [], $dataName = '') {
		parent::__construct($name, $data, $dataName);
		$this->randomKeyName = 'table_config_' . str_pad(rand(0, 99999), 5, 0, STR_PAD_LEFT);
	}

	/**
	 * @return void
	 */
	public function testSave() {
		$sessionEngine = new SessionEngine();
		$tableConfig = new TableConfig();
		$tableConfig->setConfigName($this->randomKeyName);
		$this->assertEquals(true, $sessionEngine->save($tableConfig));
	}

	/**
	 * @return void
	 */
	public function testCheck() {
		$sessionEngine = new SessionEngine();
	    $tableConfig = new TableConfig();
	    $tableConfig->setConfigName($this->randomKeyName);
		$sessionEngine->save($tableConfig);
		$this->assertEquals(true, $sessionEngine->exists($this->randomKeyName));
	}

	/**
	 * @return void
	 */
	public function testRead() {
		$sessionEngine = new SessionEngine();
	    $tableConfig = new TableConfig();
	    $tableConfig->setConfigName($this->randomKeyName);
		$sessionEngine->save($tableConfig);
		$this->assertInstanceOf(TableConfig::class, $sessionEngine->read($this->randomKeyName));
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$sessionEngine = new SessionEngine();
		$tableConfig = new TableConfig();
		$tableConfig->setConfigName($this->randomKeyName);
		$sessionEngine->save($tableConfig);
		$exist = $sessionEngine->exists($this->randomKeyName);
		$deleted = $sessionEngine->delete($this->randomKeyName);
		$this->assertEquals($exist, $deleted);
	}

}
