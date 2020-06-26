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
use DataTables\Table\Option\MainOption;
use InvalidArgumentException;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

/**
 * Class OptionsOptionPZTraitTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class OptionsOptionPZTraitTest extends TestCase {

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
	public function testSetCheckSearchSmart() {
		$searchSmart = $this->MainOption->isSearchSmart();
		$this->MainOption->setSearchSmart(!$searchSmart);
		$this->assertEquals(!$searchSmart, $this->MainOption->isSearchSmart());
		$this->MainOption->setSearchSmart($searchSmart);
		$this->assertEquals($searchSmart, $this->MainOption->isSearchSmart());
	}

	/**
	 * @return void
	 */
	public function testGetSetPagingType() {
		foreach (MainOption::ALLOWED_PAGING_TYPES as $allowedType) {
			$this->MainOption->setPagingType($allowedType);
			$this->assertEquals($allowedType, $this->MainOption->getPagingType());
		}
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPagingType('abc');
	}

	/**
	 * @return void
	 */
	public function testSetCheckSearchRegex() {
		$searchRegex = $this->MainOption->isSearchRegex();
		$this->MainOption->setSearchRegex(!$searchRegex);
		$this->assertEquals(!$searchRegex, $this->MainOption->isSearchRegex());
		$this->MainOption->setSearchRegex($searchRegex);
		$this->assertEquals($searchRegex, $this->MainOption->isSearchRegex());
	}

	/**
	 * @return void
	 */
	public function testSetGetSearchSearch() {
		$this->assertEquals('', $this->MainOption->getSearchSearch());
		$this->MainOption->setSearchSearch('abc');
		$this->assertEquals('abc', $this->MainOption->getSearchSearch());
	}

	/**
	 * @return void
	 */
	public function testSetCheckScrollCollapse() {
		$scrollCollapse = $this->MainOption->isScrollCollapse();
		$this->MainOption->setScrollCollapse(!$scrollCollapse);
		$this->assertEquals(!$scrollCollapse, $this->MainOption->isScrollCollapse());
		$this->MainOption->setScrollCollapse($scrollCollapse);
		$this->assertEquals($scrollCollapse, $this->MainOption->isScrollCollapse());
	}

	/**
	 * @return void
	 */
	public function testSetGetRenderer() {
		$this->MainOption->setRenderer('bootstrap');
		$this->assertEquals('bootstrap', $this->MainOption->getRenderer());
		$this->MainOption->setRenderer(['header' => 'jqueryui', 'pageButton' => 'bootstrap']);
		$this->assertEquals(['header' => 'jqueryui', 'pageButton' => 'bootstrap'], $this->MainOption->getRenderer());
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidType1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setRenderer(1);
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidType2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setRenderer([2 => '']);
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidType3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setRenderer(['header' => true]);
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidKey() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setRenderer(['abc' => '']);
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchCols() {
		$this->MainOption->setSearchCols([null, ['search' => 'abc', 'regex' => true]]);
		$this->assertEquals([null, ['search' => 'abc', 'regex' => true]], $this->MainOption->getSearchCols());
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchColsInvalidFormat1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setSearchCols([null, ['abc' => 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchColsInvalidFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setSearchCols([null, ['regex' => 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchColsInvalidFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setSearchCols([null, ['search' => true]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetRowId() {
		$this->MainOption->setRowId('abc');
		$this->assertEquals('abc', $this->MainOption->getRowId());
	}

	/**
	 * @return void
	 */
	public function testSetCheckSearchCaseInsensitive() {
		$searchCaseInsensitive = $this->MainOption->isSearchCaseInsensitive();
		$this->MainOption->setSearchCaseInsensitive(!$searchCaseInsensitive);
		$this->assertEquals(!$searchCaseInsensitive, $this->MainOption->isSearchCaseInsensitive());
		$this->MainOption->setSearchCaseInsensitive($searchCaseInsensitive);
		$this->assertEquals($searchCaseInsensitive, $this->MainOption->isSearchCaseInsensitive());
	}

	/**
	 * @return void
	 */
	public function testGetSetStateDuration() {
		$this->MainOption->setStateDuration(1234);
		$this->assertEquals(1234, $this->MainOption->getStateDuration());
	}

	/**
	 * @return void
	 */
	public function testGetSetStateDurationInvalid() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setStateDuration(-10);
	}

	/**
	 * @return void
	 */
	public function testGetSetPageLength() {
		$this->MainOption->setPageLength(15);
		$this->assertEquals(15, $this->MainOption->getPageLength());
	}

	/**
	 * @return void
	 */
	public function testGetSetPageLengthInvalid() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setPageLength(-10);
	}

	/**
	 * @return void
	 */
	public function testSetCheckRetrieve() {
		$retrieve = $this->MainOption->isRetrieve();
		$this->MainOption->setRetrieve(!$retrieve);
		$this->assertEquals(!$retrieve, $this->MainOption->isRetrieve());
		$this->MainOption->setRetrieve($retrieve);
		$this->assertEquals($retrieve, $this->MainOption->isRetrieve());
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchDelay() {
		$this->MainOption->setSearchDelay(456);
		$this->assertEquals(456, $this->MainOption->getSearchDelay());
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchDelayInvalid() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setSearchDelay(-10);
	}

	/**
	 * @return void
	 */
	public function testGetSetTabIndex() {
		$this->MainOption->setTabIndex(24);
		$this->assertEquals(24, $this->MainOption->getTabIndex());
	}

	/**
	 * @return void
	 */
	public function testGetSetStripeClasses() {
		$this->MainOption->setStripeClasses(['cssClass1', 'cssClass2']);
		$this->assertEquals(['cssClass1', 'cssClass2'], $this->MainOption->getStripeClasses());
	}

	/**
	 * @return void
	 */
	public function testGetSetStripeClassesInvalid1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setStripeClasses(['abc ' => 'cssClass2']);
	}

	/**
	 * @return void
	 */
	public function testGetSetStripeClassesInvalid2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setStripeClasses([true]);
	}

}
