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

use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Table\Option\MainOption;
use DataTables\Table\Option\Section\OptionsOption;
use InvalidArgumentException;

/**
 * Class OptionsOptionTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class OptionsOptionTest extends TestCase {

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
		$this->MainOption = new MainOption();
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
	public function testGetSetDom() {
		$newDom = 'rpitfl';
		$this->assertInstanceOf(MainOption::class, $this->MainOption->Options->setDom($newDom));
		$this->assertEquals($newDom, $this->MainOption->Options->getDom());
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderFixed() {
		$newOrderFixed = [[0, 'asc'], [1, 'desc']];
		$this->MainOption->Options->setOrderFixed($newOrderFixed);
		$this->assertEquals($newOrderFixed, $this->MainOption->Options->getOrderFixed());

		$newOrderFixed = [
			'pre' => [[0, 'asc'], [1, 'desc']],
			'post' => [[0, 'asc'], [1, 'desc']],
		];
		$this->MainOption->Options->setOrderFixed($newOrderFixed);
		$this->assertEquals($newOrderFixed, $this->MainOption->Options->getOrderFixed());
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['abc']);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['abc' => []]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['spre' => ['abc' => 'desc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['pre' => [0 => 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongSize() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed([['abc1', 'abc2', 'abc3']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongParameter1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed([['abc1', 'desc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongParameter2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed([[0, 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongArrayFormat() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['abc' => [[0, 'asc']]]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongSize() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['pre' => ['abc1', 'abc2', 'abc3']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongParameter1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['post' => ['abc1', 'asc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongParameter2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrderFixed(['pre' => [0, 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testSetCheckSearchSmart() {
		$searchSmart = $this->MainOption->Options->isSearchSmart();
		$this->MainOption->Options->setSearchSmart(!$searchSmart);
		$this->assertEquals(!$searchSmart, $this->MainOption->Options->isSearchSmart());
		$this->MainOption->Options->setSearchSmart($searchSmart);
		$this->assertEquals($searchSmart, $this->MainOption->Options->isSearchSmart());
	}

	/**
	 * @return void
	 */
	public function testGetSetPagingType() {
		foreach (OptionsOption::ALLOWED_PAGING_TYPES as $allowedType) {
			$this->MainOption->Options->setPagingType($allowedType);
			$this->assertEquals($allowedType, $this->MainOption->Options->getPagingType());
		}
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setPagingType('abc');
	}

	/**
	 * @return void
	 */
	public function testSetCheckSearchRegex() {
		$searchRegex = $this->MainOption->Options->isSearchRegex();
		$this->MainOption->Options->setSearchRegex(!$searchRegex);
		$this->assertEquals(!$searchRegex, $this->MainOption->Options->isSearchRegex());
		$this->MainOption->Options->setSearchRegex($searchRegex);
		$this->assertEquals($searchRegex, $this->MainOption->Options->isSearchRegex());
	}

	/**
	 * @return void
	 */
	public function testSetCheckOrderCellsTop() {
		$orderCellsTop = $this->MainOption->Options->isOrderCellsTop();
		$this->MainOption->Options->setOrderCellsTop(!$orderCellsTop);
		$this->assertEquals(!$orderCellsTop, $this->MainOption->Options->isOrderCellsTop());
		$this->MainOption->Options->setOrderCellsTop($orderCellsTop);
		$this->assertEquals($orderCellsTop, $this->MainOption->Options->isOrderCellsTop());
	}

	/**
	 * @return void
	 */
	public function testSetGetSearchSearch() {
		$this->assertEquals('', $this->MainOption->Options->getSearchSearch());
		$this->MainOption->Options->setSearchSearch('abc');
		$this->assertEquals('abc', $this->MainOption->Options->getSearchSearch());
	}

	/**
	 * @return void
	 */
	public function testSetCheckScrollCollapse() {
		$scrollCollapse = $this->MainOption->Options->isScrollCollapse();
		$this->MainOption->Options->setScrollCollapse(!$scrollCollapse);
		$this->assertEquals(!$scrollCollapse, $this->MainOption->Options->isScrollCollapse());
		$this->MainOption->Options->setScrollCollapse($scrollCollapse);
		$this->assertEquals($scrollCollapse, $this->MainOption->Options->isScrollCollapse());
	}

	/**
	 * @return void
	 */
	public function testSetGetRenderer() {
		$this->MainOption->Options->setRenderer('bootstrap');
		$this->assertEquals('bootstrap', $this->MainOption->Options->getRenderer());
		$this->MainOption->Options->setRenderer(['header' => 'jqueryui', 'pageButton' => 'bootstrap']);
		$this->assertEquals(['header' => 'jqueryui', 'pageButton' => 'bootstrap'], $this->MainOption->Options->getRenderer());
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidType1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setRenderer(1);
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidType2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setRenderer([2 => '']);
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidType3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setRenderer(['header' => true]);
	}

	/**
	 * @return void
	 */
	public function testSetGetRendererInvalidKey() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setRenderer(['abc' => '']);
	}

	/**
	 * @return void
	 */
	public function testSetCheckOrderMulti() {
		$orderMulti = $this->MainOption->Options->isOrderMulti();
		$this->MainOption->Options->setOrderMulti(!$orderMulti);
		$this->assertEquals(!$orderMulti, $this->MainOption->Options->isOrderMulti());
		$this->MainOption->Options->setOrderMulti($orderMulti);
		$this->assertEquals($orderMulti, $this->MainOption->Options->isOrderMulti());
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchCols() {
		$this->MainOption->Options->setSearchCols([null, ['search' => 'abc', 'regex' => true]]);
		$this->assertEquals([null, ['search' => 'abc', 'regex' => true]], $this->MainOption->Options->getSearchCols());
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchColsInvalidFormat1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setSearchCols([null, ['abc' => 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchColsInvalidFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setSearchCols([null, ['regex' => 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchColsInvalidFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setSearchCols([null, ['search' => true]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetDeferLoading() {
		$this->MainOption->Options->setDeferLoading(52);
		$this->assertEquals(52, $this->MainOption->Options->getDeferLoading());
		$this->MainOption->Options->setDeferLoading([57, 100]);
		$this->assertEquals([57, 100], $this->MainOption->Options->getDeferLoading());
	}

	/**
	 * @return void
	 */
	public function testGetSetDeferLoadingInvalidFormat1() {
		$this->expectException(FatalErrorException::class);
		$this->MainOption->Options->setDeferLoading(true);
	}

	/**
	 * @return void
	 */
	public function testGetSetDeferLoadingInvalidFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setDeferLoading([3, 4, 5]);
	}

	/**
	 * @return void
	 */
	public function testGetSetDeferLoadingInvalidFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setDeferLoading([true, '2']);
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenu() {
		$this->MainOption->Options->setLengthMenu([10, 25, 50, 75, 100]);
		$this->assertEquals([10, 25, 50, 75, 100], $this->MainOption->Options->getLengthMenu());
		$this->MainOption->Options->setLengthMenu([[10, 25, 50, -1], [10, 25, 50, 'All']]);
		$this->assertEquals([[10, 25, 50, -1], [10, 25, 50, 'All']], $this->MainOption->Options->getLengthMenu());
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenuInvalidFormat1() {
		$this->expectException(FatalErrorException::class);
		$this->MainOption->Options->setLengthMenu([[5, 10], ['five', 'ten', 'other']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenuInvalidFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setLengthMenu([['abc' => 5], ['label1' => 'five']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenuInvalidFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setLengthMenu([[5, 'ab' => 10]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetRowId() {
		$this->MainOption->Options->setRowId('abc');
		$this->assertEquals('abc', $this->MainOption->Options->getRowId());
	}

	/**
	 * @return void
	 */
	public function testSetCheckSearchCaseInsensitive() {
		$searchCaseInsensitive = $this->MainOption->Options->isSearchCaseInsensitive();
		$this->MainOption->Options->setSearchCaseInsensitive(!$searchCaseInsensitive);
		$this->assertEquals(!$searchCaseInsensitive, $this->MainOption->Options->isSearchCaseInsensitive());
		$this->MainOption->Options->setSearchCaseInsensitive($searchCaseInsensitive);
		$this->assertEquals($searchCaseInsensitive, $this->MainOption->Options->isSearchCaseInsensitive());
	}

	/**
	 * @return void
	 */
	public function testGetSetStateDuration() {
		$this->MainOption->Options->setStateDuration(1234);
		$this->assertEquals(1234, $this->MainOption->Options->getStateDuration());
	}

	/**
	 * @return void
	 */
	public function testGetSetStateDurationInvalid() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setStateDuration(-10);
	}

	/**
	 * @return void
	 */
	public function testGetSetPageLength() {
		$this->MainOption->Options->setPageLength(15);
		$this->assertEquals(15, $this->MainOption->Options->getPageLength());
	}

	/**
	 * @return void
	 */
	public function testGetSetPageLengthInvalid() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setPageLength(-10);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrder() {
		$this->MainOption->Options->setOrder([[0, 'asc'], [1, 'desc']]);
		$this->assertEquals([[0, 'asc'], [1, 'desc']], $this->MainOption->Options->getOrder());
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrder([0, 'asc']);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrder([[0, 'asc', 2]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrder([[0, true]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid4() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrder([['as', 'as']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid5() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrder([[1, 3]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid6() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setOrder([[0, 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testSetCheckRetrieve() {
		$retrieve = $this->MainOption->Options->isRetrieve();
		$this->MainOption->Options->setRetrieve(!$retrieve);
		$this->assertEquals(!$retrieve, $this->MainOption->Options->isRetrieve());
		$this->MainOption->Options->setRetrieve($retrieve);
		$this->assertEquals($retrieve, $this->MainOption->Options->isRetrieve());
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchDelay() {
		$this->MainOption->Options->setSearchDelay(456);
		$this->assertEquals(456, $this->MainOption->Options->getSearchDelay());
	}

	/**
	 * @return void
	 */
	public function testGetSetSearchDelayInvalid() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setSearchDelay(-10);
	}

	/**
	 * @return void
	 */
	public function testSetCheckDestroy() {
		$destroy = $this->MainOption->Options->isDestroy();
		$this->MainOption->Options->setDestroy(!$destroy);
		$this->assertEquals(!$destroy, $this->MainOption->Options->isDestroy());
		$this->MainOption->Options->setDestroy($destroy);
		$this->assertEquals($destroy, $this->MainOption->Options->isDestroy());
	}

	/**
	 * @return void
	 */
	public function testGetSetTabIndex() {
		$this->MainOption->Options->setTabIndex(24);
		$this->assertEquals(24, $this->MainOption->Options->getTabIndex());
	}

	/**
	 * @return void
	 */
	public function testGetSetDisplayStart() {
		$this->MainOption->Options->setDisplayStart(16);
		$this->assertEquals(16, $this->MainOption->Options->getDisplayStart());
	}

	/**
	 * @return void
	 */
	public function testGetSetStripeClasses() {
		$this->MainOption->Options->setStripeClasses(['cssClass1', 'cssClass2']);
		$this->assertEquals(['cssClass1', 'cssClass2'], $this->MainOption->Options->getStripeClasses());
	}

	/**
	 * @return void
	 */
	public function testGetSetStripeClassesInvalid1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setStripeClasses(['abc ' => 'cssClass2']);
	}

	/**
	 * @return void
	 */
	public function testGetSetStripeClassesInvalid2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->Options->setStripeClasses([true]);
	}

	/**
	 * @return void
	 */
	public function testSetCheckOrderClasses() {
		$orderClasses = $this->MainOption->Options->isOrderClasses();
		$this->MainOption->Options->setOrderClasses(!$orderClasses);
		$this->assertEquals(!$orderClasses, $this->MainOption->Options->isOrderClasses());
		$this->MainOption->Options->setOrderClasses($orderClasses);
		$this->assertEquals($orderClasses, $this->MainOption->Options->isOrderClasses());
	}

}
