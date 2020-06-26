<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table\Option\Section;

use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use InvalidArgumentException;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

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
		$plugin = new Plugin();
		$plugin->bootstrap(new Application(''));
		$plugin->routes(Router::createRouteBuilder(''));
		Router::setRequest(new ServerRequest());
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$this->MainOption = $configBundle->Options;
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
		$this->assertEquals('/data-tables/provider/get-tables-data/categories', $this->MainOption->getAjaxUrl());
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
