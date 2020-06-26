<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Test\TestCase\View\Helper;

use Cake\Error\FatalErrorException;
use Cake\Event\EventManager;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use DataTables\Plugin;
use DataTables\Table\Assets;
use DataTables\View\Helper\DataTablesHelper;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

/**
 * Class DataTablesHelperTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class DataTablesHelperTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\View\Helper\DataTablesHelper
	 */
	protected $DataTables;

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
		$view = new View();
		$this->DataTables = new DataTablesHelper($view);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->DataTables);

		parent::tearDown();
	}

	/**
	 * Test renderTable method
	 *
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testRenderTable(): void {
		$this->assertNotEmpty($this->DataTables->renderTable('Categories'));
		Assets::getInstance(true);
		EventManager::instance()->dispatch('View.beforeLayout');
	}

	/**
	 * Test renderTable method
	 *
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testLink(): void {

		$urlQuery = $this->DataTables->link(
			CategoriesDataTables::class,
			'abc',
			[
				'controller' => 'Provider',
				'action' => 'getTablesData',
				'plugin' => 'DataTables',
				'prefix' => false,
				'?' => ['abc' => '123'],
			]);

		$urlQuery
			->setPage(2)
			->setColumnOrderDesc('id')
			->setColumnOrderAsc('created')
			->setSearch('abc')
			->setColumnSearch('id', 'abc');

		$expected = '<a href="/data-tables/provider/get-tables-data?abc=123&amp;data-tables%5BCategories%5D%5Bpage%5D=2&amp;data-tables%5BCategories%5D%5Bcolumns%5D%5BCategories.id%5D%5Border%5D=desc&amp;data-tables%5BCategories%5D%5Bcolumns%5D%5BCategories.id%5D%5Bsearch%5D=abc&amp;data-tables%5BCategories%5D%5Bcolumns%5D%5BCategories.created%5D%5Border%5D=asc&amp;data-tables%5BCategories%5D%5Bsearch%5D=abc">abc</a>';
		$this->assertEquals($expected, $urlQuery->__toString());

		$urlQuery->setPage('last');
		$expected = '<a href="/data-tables/provider/get-tables-data?abc=123&amp;data-tables%5BCategories%5D%5Bpage%5D=last&amp;data-tables%5BCategories%5D%5Bcolumns%5D%5BCategories.id%5D%5Border%5D=desc&amp;data-tables%5BCategories%5D%5Bcolumns%5D%5BCategories.id%5D%5Bsearch%5D=abc&amp;data-tables%5BCategories%5D%5Bcolumns%5D%5BCategories.created%5D%5Border%5D=asc&amp;data-tables%5BCategories%5D%5Bsearch%5D=abc">abc</a>';
		$this->assertEquals($expected, $urlQuery->__toString());

		$this->expectException(FatalErrorException::class);
		$urlQuery->setPage(true);
	}

}
