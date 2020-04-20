<?php
declare(strict_types = 1);

namespace DataTables\Test\TestCase\Controller\Component;

use Cake\TestSuite\TestCase;

/**
 * DataTables\Controller\Component\DataTablesComponent Test Case
 */
class DataTablesComponentTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\Controller\Component\DataTablesComponent
	 */
	protected $DataTables;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->DataTables);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function test() {
		static::markTestIncomplete();
	}

}
