<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table;

use Cake\TestSuite\TestCase;
use DataTables\Table\Column;
use DataTables\Table\Columns;
use DataTables\Table\Tables;
use InvalidArgumentException;

/**
 * Class ColumnTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class ColumnTest extends TestCase {

	/**
	 * @var string[]
	 */
	protected $fixtures = [
		'plugin.DataTables.Articles',
		'plugin.DataTables.Users',
	];

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\Columns
	 */
	protected $Columns;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		/** @var \DataTables\Table\Tables $tables */
		$tables = $this->getMockBuilder(Tables::class)
			->setMockClassName('ArticlesTables')
			->getMockForAbstractClass();
		$tables->getOrmTable()->addAssociations([
			'belongsTo' => [
				'Users',
			],
		]);
		$this->Columns = new Columns($tables);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->Columns);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testSimple() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(true, $col->isDatabase());
		static::assertEquals('Users.id', $col->getName());
		$col = $this->Columns->addNonDatabaseColumn('Users.test');
		static::assertEquals(false, $col->isDatabase());
	}

	/**
	 * @return void
	 */
	public function testCellType() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		$col->setCellType('th');
		static::assertEquals('th', $col->getCellType());
		$col->setCellType('td');
		static::assertEquals('td', $col->getCellType());
		$this->expectException(InvalidArgumentException::class);
		$col->setCellType('abc');
	}

	/**
	 * @return void
	 */
	public function testClassName() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getClassName());
		$col->setClassName('abc');
		static::assertEquals('abc', $col->getClassName());
	}

	/**
	 * @return void
	 */
	public function testContentPadding() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getContentPadding());
		$col->setContentPadding('abcdfghi');
		static::assertEquals('abcdfghi', $col->getContentPadding());
	}

	/**
	 * @return void
	 */
	public function testCreatedCell() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getCreatedCell());
		$col->setCreatedCell();
		static::assertEquals([], $col->getCreatedCell());
		$col->setCreatedCell('abc');
		static::assertEquals('abc', $col->getCreatedCell());
		$col->setCreatedCell(['abc' => 1234]);
		static::assertEquals(['abc' => 1234], $col->getCreatedCell());
		$this->expectException(InvalidArgumentException::class);
		$col->setCreatedCell(12);
	}

	/**
	 * @return void
	 */
	public function testOrderDataArray() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getOrderData());
		$col->setOrderData([]);
		static::assertEquals([], $col->getOrderData());
		$col->setOrderData([1, 2, 3]);
		static::assertEquals([1, 2, 3], $col->getOrderData());
		$this->expectException(InvalidArgumentException::class);
		$col->setOrderData(['abc']);
	}

	/**
	 * @return void
	 */
	public function testOrderDataInteger() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		$col->setOrderData(1);
		static::assertEquals(1, $col->getOrderData());
		$this->expectException(InvalidArgumentException::class);
		$col->setOrderData(-1);
	}

	/**
	 * @return void
	 */
	public function testOrderDataInvalid() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		$this->expectException(InvalidArgumentException::class);
		$col->setOrderData(32.21);
	}

	/**
	 * @return void
	 */
	public function testOrderDataType() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getOrderDataType());
		foreach (Column::VALID_ORDER_DATA_TYPES as $type) {
			$col->setOrderDataType($type);
			static::assertEquals($type, $col->getOrderDataType());
	    }
		$this->expectException(InvalidArgumentException::class);
		$col->setOrderDataType('abc');
	}

	/**
	 * @return void
	 */
	public function testOrderSequence() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getOrderSequence());
		$col->setOrderSequence(['asc']);
		static::assertEquals(['asc'], $col->getOrderSequence());
		$col->setOrderSequence(['desc', 'asc']);
		static::assertEquals(['desc', 'asc'], $col->getOrderSequence());
		$this->expectException(InvalidArgumentException::class);
		$col->setOrderSequence(['desc', 'asc', 'abc']);
	}

	/**
	 * @return void
	 */
	public function testOrderable() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->isOrderable());
		$col->setOrderable(true);
		static::assertEquals(true, $col->isOrderable());
		$col->setOrderable(false);
		static::assertEquals(false, $col->isOrderable());
		$col->setOrderable(null);
		static::assertEquals(null, $col->isOrderable());
	}

	/**
	 * @return void
	 */
	public function testSearchable() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->isSearchable());
		$col->setSearchable(true);
		static::assertEquals(true, $col->isSearchable());
		$col->setSearchable(false);
		static::assertEquals(false, $col->isSearchable());
		$col->setSearchable(null);
		static::assertEquals(null, $col->isSearchable());
	}

	/**
	 * @return void
	 */
	public function testTitle() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals('Id', $col->getTitle());
		$col->setTitle('abc');
		static::assertEquals('abc', $col->getTitle());
		$col->setTitle('zzz');
		static::assertEquals('zzz', $col->getTitle());
	}

	/**
	 * @return void
	 */
	public function testType() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getType());
		foreach (Column::VALID_TYPES as $type) {
			$col->setType($type);
			static::assertEquals($type, $col->getType());
		}
		$this->expectException(InvalidArgumentException::class);
		$col->setType('abc');
	}

	/**
	 * @return void
	 */
	public function testVisible() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->isVisible());
		$col->setVisible(true);
		static::assertEquals(true, $col->isVisible());
		$col->setVisible(false);
		static::assertEquals(false, $col->isVisible());
		$col->setVisible(null);
		static::assertEquals(null, $col->isVisible());
	}

	/**
	 * @return void
	 */
	public function testWidth() {
		$col = $this->Columns->addDatabaseColumn('Users.id');
		static::assertEquals(null, $col->getWidth());
		$col->setWidth('10px');
		static::assertEquals('10px', $col->getWidth());
		$col->setWidth('10%');
		static::assertEquals('10%', $col->getWidth());
		$col->setWidth(null);
		static::assertEquals(null, $col->getWidth());
	}

}
