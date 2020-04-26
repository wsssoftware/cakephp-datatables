<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table\Option;

use Cake\TestSuite\TestCase;
use const JSON_ERROR_NONE;
use DataTables\Table\Option\MainOption;
use Exception;

/**
 * Class MainOptionTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class MainOptionTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\Option\MainOption
	 */
	protected $MainOption;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$this->MainOption = new MainOption('Categories', 'abc');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->MainOption);

		parent::tearDown();
	}

	/**
	 * Check if print all options getter and setter is working
	 *
	 * @return void
	 */
	public function testPrintAllOptions() {
		$this->MainOption->setPrintAllOptions(true);
		$this->assertEquals(true, $this->MainOption->isPrintAllOptions());
		$this->MainOption->setPrintAllOptions(false);
		$this->assertEquals(false, $this->MainOption->isPrintAllOptions());
	}

	/**
	 * Check if config getter and setter is working
	 *
	 * @return void
	 */
	public function testConfigAndMustPrint() {
		$this->MainOption->setConfig('abc', true);
		$this->assertEquals(true, $this->MainOption->getConfig('abc'));
		$this->assertEquals(true, $this->MainOption->getMustPrint('abc'));

		$this->MainOption->setConfig('def', [], false);
		$this->assertEquals([], $this->MainOption->getConfig('def'));
		$this->assertEquals(false, $this->MainOption->getMustPrint('def'));

		$this->MainOption->setMustPrint('abc', false);
		$this->assertEquals(false, $this->MainOption->getMustPrint('abc'));

		$this->assertEquals('array', getType($this->MainOption->getMustPrint()));

		$this->assertNotEmpty($this->MainOption->getConfig());
	}

	/**
	 * Check if array and json getter is working
	 *
	 * @return void
	 */
	public function testArrayJson() {
		$this->MainOption->setConfig('abc', '1234', false);
		$this->MainOption->setPrintAllOptions(true);
		$allConfig = $this->MainOption->getConfigAsArray();
		$this->MainOption->setPrintAllOptions(false);
		$config = $this->MainOption->getConfigAsArray();
		$this->assertGreaterThanOrEqual(count($config), count($allConfig));
		$this->assertEquals(true, array_key_exists('abc', $allConfig));
		$this->assertEquals(false, array_key_exists('abc', $config));

		try {
			$this->MainOption->getConfigAsJson();
		} catch (Exception $exception) {

		} finally {
			$this->assertEquals(true, json_last_error() === JSON_ERROR_NONE);
		}
	}

}
