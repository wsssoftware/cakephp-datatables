<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table;

use Cake\Error\FatalErrorException;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use DataTables\Table\Column;
use InvalidArgumentException;
use TestApp\Application;

/**
 * Class ColumnsTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
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
		$plugin = new Plugin();
		$plugin->bootstrap(new Application(''));
		$plugin->routes(Router::createRouteBuilder(''));
		Router::setRequest(new ServerRequest());
		TableRegistry::getTableLocator()->get('Articles')->addAssociations([
			'belongsTo' => [
				'Users',
			],
		]);
		$articles = Builder::getInstance()->getConfigBundle('Articles');
		$this->Columns = $articles->Columns;
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
		$count = count($this->Columns->getColumns()) + 4;
		$this->Columns->addNonDatabaseColumn('abc');
		$this->Columns->addNonDatabaseColumn('abc2');
		$this->Columns->addNonDatabaseColumn('abc3');
		$this->Columns->addDatabaseColumn('modified');
		$this->assertEquals($count, count($this->Columns->getColumns()));
		$this->expectException(FatalErrorException::class);
		$this->Columns->addNonDatabaseColumn('abc');
	}

	/**
	 * @return void
	 */
	public function testDatabaseColumn() {
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Articles.abc');
	}

	/**
	 * @return void
	 */
	public function testCustomDatabaseColumn() {
		$concat = $this->Columns->func()->concat(['id' => 'identifier', '_', 'created' => 'identifier']);
		$column = $this->Columns->addCustomDatabaseColumn($concat, 'custom_column');
		$this->assertInstanceOf(Column::class, $column);
	}

	/**
	 * @return void
	 */
	public function testGetColumnNameByIndex() {
		$this->assertEquals('Articles.id', $this->Columns->getColumnNameByIndex(0));
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn1() {
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Articles.id.id');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn2() {
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Abc.id');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn3() {
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Abc.id');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn4() {
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addDatabaseColumn('Users.test');
	}

	/**
	 * @return void
	 */
	public function testInvalidColumn5() {
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->addNonDatabaseColumn('^&^&@#');
	}

	/**
	 * @return void
	 */
	public function testEmptyColumns() {
		$this->Columns->deleteAllColumns();
		$columns = $this->Columns->getColumns();

		$this->assertGreaterThan(0, count($columns));
	}

	/**
	 * @return void
	 */
	public function testGetColumn() {
		$column = $this->Columns->getColumn('action');
		$this->assertEquals('action', $column->getName());
		$column = $this->Columns->getColumn('id');
		$this->assertEquals('Articles.id', $column->getName());
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->getColumn('abc');
	}

	/**
	 * @return void
	 */
	public function testDeleteColumn() {
		$count = count($this->Columns->getColumns()) - 2;
		$this->Columns->deleteColumn('id');
		$this->Columns->deleteColumn('action');
		$this->assertEquals($count, count($this->Columns->getColumns()));
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->deleteColumn('abc');
	}

	/**
	 * @return void
	 */
	public function testAddNewColumnWithIndex() {
		$this->Columns->addNonDatabaseColumn('abc', 0);
		$this->assertEquals('abc', $this->Columns->getColumnByIndex(0)->getName());
	}

	/**
	 * @return void
	 */
	public function testChangeColumnIndex() {
		$this->Columns->changeColumnIndex('action', 0);
		$this->Columns->changeColumnIndex('created', 1);
		$this->assertEquals('action', $this->Columns->getColumnByIndex(0)->getName());
		$this->assertEquals('Articles.created', $this->Columns->getColumnByIndex(1)->getName());
		$this->expectException(InvalidArgumentException::class);
		$this->Columns->changeColumnIndex('abc', 2);
	}

	/**
	 * @return void
	 */
	public function testGetIndexByName() {
		$index = $this->Columns->getColumnIndexByName('title');
		$this->assertEquals(1, $index);
		$index = $this->Columns->getColumnIndexByName('action');
		$this->assertEquals(6, $index);

		$this->expectException(InvalidArgumentException::class);
		$this->Columns->getColumnIndexByName('abc');
	}

}
