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

use Cake\Error\FatalErrorException;
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
 * Class OptionsOptionTraitAOTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class OptionsOptionAOTraitTest extends TestCase {

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
	public function testGetSetDisplayStart() {
		$this->MainOption->setDisplayStart(16);
		$this->assertEquals(16, $this->MainOption->getDisplayStart());
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
