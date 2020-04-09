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

namespace DataTables\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use DataTables\View\Helper\DataTablesHelper;

/**
 * Class DataTablesHelperTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class DataTablesHelperTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\View\Helper\DataTablesHelper
	 */
	protected $DataTables;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$view = new View();
		$this->DataTables = new DataTablesHelper($view);
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
	 * Test renderTable method
	 *
	 * @return void
	 */
	public function testRenderTable(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
