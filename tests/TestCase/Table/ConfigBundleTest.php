<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\Table;

use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use TestApp\Application;

/**
 * Class ConfigBundleTest
 * Created by allancarvalho in abril 27, 2020
 */
class ConfigBundleTest extends TestCase {

	/**
	 * @var \DataTables\Table\ConfigBundle
	 */
	private $ConfigBundle;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$plugin = new Plugin();
		$plugin->bootstrap(new Application(''));
		$plugin->routes(Router::createRouteBuilder(''));
		Router::setRequest(new ServerRequest());
		$this->ConfigBundle = Builder::getInstance()->getConfigBundle('Articles');
	}

	/**
	 * @return void
	 */
	public function test() {
		$this->assertEquals('TestApp\DataTables\ArticlesDataTables', $this->ConfigBundle->getDataTableFQN());
	}

}
