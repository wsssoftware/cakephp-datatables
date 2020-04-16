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

use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Table\Columns;
use DataTables\Table\Tables;
use InvalidArgumentException;

/**
 * Class ColumnsTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class ColumnsTest extends TestCase {

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
	public function testNonDatabaseColumn() {
		$this->Columns->addNonDatabaseColumn('abc');
		$this->Columns->addNonDatabaseColumn('abc2');
		$this->Columns->addNonDatabaseColumn('abc3');
		$this->assertEquals(3, count($this->Columns->getColumns()));
		$this->expectException(FatalErrorException::class);
		$this->Columns->addNonDatabaseColumn('abc');
	}

	/**
	 * @return void
	 */
	public function testDatabaseColumn() {
		$this->loadFixtures();
		$this->Columns->addDatabaseColumn('Articles.id');
		$this->Columns->addDatabaseColumn('created');
		$this->Columns->addDatabaseColumn('Articles.title');
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Articles.abc');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn1() {
		$this->loadFixtures();
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Articles.id.id');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn2() {
		$this->loadFixtures();
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Abc.id');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn3() {
		$this->loadFixtures();
		$this->Columns->addDatabaseColumn('Users.id');
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Abc.id');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn4() {
		$this->loadFixtures();
		$this->Columns->addDatabaseColumn('Users.id');
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Users.test');
	}

}
