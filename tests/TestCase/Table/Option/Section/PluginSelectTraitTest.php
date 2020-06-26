<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
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
 * Class PluginSelectTraitTest
 * Created by allancarvalho in maio 02, 2020
 */
class PluginSelectTraitTest extends TestCase {

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
	public function testSetPluginSelectLanguageColumns() {
		$this->MainOption->setPluginSelectLanguageColumns('abc');
		$this->assertEquals('abc', $this->MainOption->getPluginSelectLanguageColumns());
		$this->MainOption->setPluginSelectLanguageColumns(['_' => 'abc']);
		$this->assertEquals(['_' => 'abc'], $this->MainOption->getPluginSelectLanguageColumns());
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectLanguageColumns(['abc' => 'abc']);
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectLanguageColumnsInvalidType() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectLanguageColumns(true);
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectItems() {
		$this->MainOption->setPluginSelectItems('row');
		$this->assertEquals('row', $this->MainOption->getPluginSelectItems());
		$this->MainOption->setPluginSelectItems('column');
		$this->assertEquals('column', $this->MainOption->getPluginSelectItems());
		$this->MainOption->setPluginSelectItems('cell');
		$this->assertEquals('cell', $this->MainOption->getPluginSelectItems());
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectItems('abc');
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectInfo() {
		$this->MainOption->setPluginSelectInfo(true);
		$this->assertTrue($this->MainOption->isPluginSelectInfo());
		$this->MainOption->setPluginSelectInfo(false);
		$this->assertFalse($this->MainOption->isPluginSelectInfo());
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectClassName() {
		$this->MainOption->setPluginSelectClassName('abc');
		$this->assertEquals('abc', $this->MainOption->getPluginSelectClassName());
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectLanguageRows() {
		$this->MainOption->setPluginSelectLanguageRows('abc');
		$this->assertEquals('abc', $this->MainOption->getPluginSelectLanguageRows());
		$this->MainOption->setPluginSelectLanguageRows(['_' => 'abc']);
		$this->assertEquals(['_' => 'abc'], $this->MainOption->getPluginSelectLanguageRows());
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectLanguageRows(['abc' => 'abc']);
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectLanguageRowsInvalidType() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectLanguageRows(true);
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectBlurable() {
		$this->MainOption->setPluginSelectBlurable(true);
		$this->assertTrue($this->MainOption->isPluginSelectBlurable());
		$this->MainOption->setPluginSelectBlurable(false);
		$this->assertFalse($this->MainOption->isPluginSelectBlurable());
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectToggleable() {
		$this->MainOption->setPluginSelectToggleable(true);
		$this->assertTrue($this->MainOption->isPluginSelectToggleable());
		$this->MainOption->setPluginSelectToggleable(false);
		$this->assertFalse($this->MainOption->isPluginSelectToggleable());
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectEnabled() {
		$this->MainOption->setPluginSelectEnabled(true);
		$this->assertTrue($this->MainOption->isPluginSelectEnabled());
		$this->MainOption->setPluginSelectEnabled(false);
		$this->assertFalse($this->MainOption->isPluginSelectEnabled());
		$this->MainOption->setPluginSelectBlurable(true);
		$this->assertTrue($this->MainOption->isPluginSelectEnabled());
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectStyle() {
		$this->MainOption->setPluginSelectStyle('api');
		$this->assertEquals('api', $this->MainOption->getPluginSelectStyle());
		$this->MainOption->setPluginSelectStyle('single');
		$this->assertEquals('single', $this->MainOption->getPluginSelectStyle());
		$this->MainOption->setPluginSelectStyle('multi');
		$this->assertEquals('multi', $this->MainOption->getPluginSelectStyle());
		$this->MainOption->setPluginSelectStyle('os');
		$this->assertEquals('os', $this->MainOption->getPluginSelectStyle());
		$this->MainOption->setPluginSelectStyle('multi+shift');
		$this->assertEquals('multi+shift', $this->MainOption->getPluginSelectStyle());
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectStyle('abc');
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectLanguageCells() {
		$this->MainOption->setPluginSelectLanguageCells('abc');
		$this->assertEquals('abc', $this->MainOption->getPluginSelectLanguageCells());
		$this->MainOption->setPluginSelectLanguageCells(['_' => 'abc']);
		$this->assertEquals(['_' => 'abc'], $this->MainOption->getPluginSelectLanguageCells());
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectLanguageCells(['abc' => 'abc']);
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectLanguageCellsInvalidType() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPluginSelectLanguageCells(true);
	}

	/**
	 * @return void
	 */
	public function testSetPluginSelectSelector() {
		$this->MainOption->setPluginSelectSelector('abc');
		$this->assertEquals('abc', $this->MainOption->getPluginSelectSelector());
	}

}
