<?php
declare(strict_types = 1);

namespace DataTables\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use DataTables\Controller\Component\CssComponent;

/**
 * DataTables\Controller\Component\CssComponent Test Case
 */
class CssComponentTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\Controller\Component\CssComponent
	 */
	protected $Css;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$registry = new ComponentRegistry();
		$this->Css = new CssComponent($registry);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->Css);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function test() {
		static::markTestIncomplete();
	}

}
