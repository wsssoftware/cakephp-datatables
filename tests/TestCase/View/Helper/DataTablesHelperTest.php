<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Test\TestCase\View\Helper;

use Cake\Event\EventManager;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use DataTables\Plugin;
use DataTables\Table\ResourcesConfig\LocalResourcesConfig;
use DataTables\View\Helper\DataTablesHelper;
use TestApp\Application;

/**
 * Class DataTablesHelperTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
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
	 * @return void
	 * @throws \ReflectionException
	 */
	public function testRenderTable(): void {
		$this->assertNotEmpty($this->DataTables->renderTable('Categories'));
		LocalResourcesConfig::getInstance(true);
		EventManager::instance()->dispatch('View.beforeLayout');
	}

}
