<?php
declare(strict_types = 1);

namespace DataTables\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use DataTables\Controller\Component\JsComponent;

/**
 * DataTables\Controller\Component\JsComponent Test Case
 */
class JsComponentTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\Controller\Component\JsComponent
	 */
	protected $Js;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$registry = new ComponentRegistry();
		$this->Js = new JsComponent($registry);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->Js);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function test() {
		static::markTestIncomplete();
	}

}
