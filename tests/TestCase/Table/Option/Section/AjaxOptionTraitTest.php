<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table\Option\Section;

use Cake\TestSuite\TestCase;
use DataTables\Table\Option\MainOption;
use InvalidArgumentException;

/**
 * Class AjaxOptionTraitTest
 * Created by allancarvalho in abril 24, 2020
 */
class AjaxOptionTraitTest extends TestCase {

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
		$this->MainOption = new MainOption('abc');
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
	 * @return void
	 */
	public function testAjaxUrl() {
		$this->assertEquals('abc', $this->MainOption->getAjaxUrl());
	}

	/**
	 * @return void
	 */
	public function testAjaxType() {
		$this->assertEquals('GET', $this->MainOption->getAjaxRequestType());
		$this->MainOption->setAjaxRequestType('POST');
		$this->assertEquals('POST', $this->MainOption->getAjaxRequestType());
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setAjaxRequestType('ABC');
	}

}
