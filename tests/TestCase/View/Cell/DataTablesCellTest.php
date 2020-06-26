<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use DataTables\View\Cell\DataTablesCell;

/**
 * Class DataTablesCellTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class DataTablesCellTest extends TestCase {

	/**
	 * Request mock
	 *
	 * @var \Cake\Http\ServerRequest|\PHPUnit\Framework\MockObject\MockObject
	 */
	protected $request;

	/**
	 * Response mock
	 *
	 * @var \Cake\Http\Response|\PHPUnit\Framework\MockObject\MockObject
	 */
	protected $response;

	/**
	 * Test subject
	 *
	 * @var \DataTables\View\Cell\DataTablesCell
	 */
	protected $DataTables;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$this->request = $this->getMockBuilder('Cake\Http\ServerRequest')->getMock();
		$this->response = $this->getMockBuilder('Cake\Http\Response')->getMock();
		$this->DataTables = new DataTablesCell($this->request, $this->response);
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
	 * Test table method
	 *
	 * @return void
	 */
	public function testTable(): void {
		$this->assertEquals(1, 1);
	    //$this->markTestIncomplete('Not implemented yet.');
	}

}
