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
use InvalidArgumentException;

/**
 * Class OptionsOptionTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class OptionsOptionTraitTest extends TestCase {

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
	public function testGetSetDom() {
		$newDom = 'rpitfl';
		$this->assertInstanceOf(MainOption::class, $this->MainOption->setDom($newDom));
		$this->assertEquals($newDom, $this->MainOption->getDom());
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderFixed() {
		$newOrderFixed = [[0, 'asc'], [1, 'desc']];
		$this->MainOption->setOrderFixed($newOrderFixed);
		$this->assertEquals($newOrderFixed, $this->MainOption->getOrderFixed());

		$newOrderFixed = [
			'pre' => [[0, 'asc'], [1, 'desc']],
			'post' => [[0, 'asc'], [1, 'desc']],
		];
		$this->MainOption->setOrderFixed($newOrderFixed);
		$this->assertEquals($newOrderFixed, $this->MainOption->getOrderFixed());
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['abc']);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['abc' => []]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['spre' => ['abc' => 'desc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongArrayFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['pre' => [0 => 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongSize() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed([['abc1', 'abc2', 'abc3']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongParameter1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed([['abc1', 'desc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedDefaultWrongParameter2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed([[0, 'abc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongArrayFormat() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['abc' => [[0, 'asc']]]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongSize() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['pre' => ['abc1', 'abc2', 'abc3']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongParameter1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['post' => ['abc1', 'asc']]);
	}

	/**
	 * @return void
	 */
	public function testSetOrderFixedObjectWrongParameter2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrderFixed(['pre' => [0, 'abc']]);
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
	public function testSetCheckOrderCellsTop() {
		$orderCellsTop = $this->MainOption->isOrderCellsTop();
		$this->MainOption->setOrderCellsTop(!$orderCellsTop);
		$this->assertEquals(!$orderCellsTop, $this->MainOption->isOrderCellsTop());
		$this->MainOption->setOrderCellsTop($orderCellsTop);
		$this->assertEquals($orderCellsTop, $this->MainOption->isOrderCellsTop());
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
	public function testSetCheckOrderMulti() {
		$orderMulti = $this->MainOption->isOrderMulti();
		$this->MainOption->setOrderMulti(!$orderMulti);
		$this->assertEquals(!$orderMulti, $this->MainOption->isOrderMulti());
		$this->MainOption->setOrderMulti($orderMulti);
		$this->assertEquals($orderMulti, $this->MainOption->isOrderMulti());
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
	public function testGetSetDeferLoading() {
		$this->MainOption->setDeferLoading(52);
		$this->assertEquals(52, $this->MainOption->getDeferLoading());
		$this->MainOption->setDeferLoading([57, 100]);
		$this->assertEquals([57, 100], $this->MainOption->getDeferLoading());
	}

	/**
	 * @return void
	 */
	public function testGetSetDeferLoadingInvalidFormat1() {
		$this->expectException(FatalErrorException::class);
		$this->MainOption->setDeferLoading(true);
	}

	/**
	 * @return void
	 */
	public function testGetSetDeferLoadingInvalidFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setDeferLoading([3, 4, 5]);
	}

	/**
	 * @return void
	 */
	public function testGetSetDeferLoadingInvalidFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setDeferLoading([true, '2']);
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenu() {
		$this->MainOption->setLengthMenu([10, 25, 50, 75, 100]);
		$this->assertEquals([10, 25, 50, 75, 100], $this->MainOption->getLengthMenu());
		$this->MainOption->setLengthMenu([[10, 25, 50, -1], [10, 25, 50, 'All']]);
		$this->assertEquals([[10, 25, 50, -1], [10, 25, 50, 'All']], $this->MainOption->getLengthMenu());
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenuInvalidFormat1() {
		$this->expectException(FatalErrorException::class);
		$this->MainOption->setLengthMenu([[5, 10], ['five', 'ten', 'other']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenuInvalidFormat2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setLengthMenu([['abc' => 5], ['label1' => 'five']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetLengthMenuInvalidFormat3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setLengthMenu([[5, 'ab' => 10]]);
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
	public function testGetSetOrder() {
		$this->MainOption->setOrder([[0, 'asc'], [1, 'desc']]);
		$this->assertEquals([[0, 'asc'], [1, 'desc']], $this->MainOption->getOrder());
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid1() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrder([0, 'asc']);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid2() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrder([[0, 'asc', 2]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid3() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrder([[0, true]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid4() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrder([['as', 'as']]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid5() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrder([[1, 3]]);
	}

	/**
	 * @return void
	 */
	public function testGetSetOrderInvalid6() {
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setOrder([[0, 'abc']]);
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
	public function testSetCheckDestroy() {
		$destroy = $this->MainOption->isDestroy();
		$this->MainOption->setDestroy(!$destroy);
		$this->assertEquals(!$destroy, $this->MainOption->isDestroy());
		$this->MainOption->setDestroy($destroy);
		$this->assertEquals($destroy, $this->MainOption->isDestroy());
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
	public function testGetSetDisplayStart() {
		$this->MainOption->setDisplayStart(16);
		$this->assertEquals(16, $this->MainOption->getDisplayStart());
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

	/**
	 * @return void
	 */
	public function testSetCheckOrderClasses() {
		$orderClasses = $this->MainOption->isOrderClasses();
		$this->MainOption->setOrderClasses(!$orderClasses);
		$this->assertEquals(!$orderClasses, $this->MainOption->isOrderClasses());
		$this->MainOption->setOrderClasses($orderClasses);
		$this->assertEquals($orderClasses, $this->MainOption->isOrderClasses());
	}

}
