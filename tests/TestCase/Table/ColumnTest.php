<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\Table;

use Cake\TestSuite\TestCase;
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

}
