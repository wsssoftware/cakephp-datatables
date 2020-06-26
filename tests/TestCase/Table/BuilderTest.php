<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\Table;

use Cake\Error\FatalErrorException;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use TestApp\Application;
use TestApp\OtherPath\ArticlesDataTables;

/**
 * Class BuilderTest
 * Created by allancarvalho in abril 27, 2020
 */
class BuilderTest extends TestCase {

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
	}

	/**
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testNotInstanceOfDataTables() {
		$this->expectException(FatalErrorException::class);
		Builder::getInstance()->getConfigBundle('WrongConfig');
	}

	/**
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testNotFoundClass() {
		$this->expectException(FatalErrorException::class);
		Builder::getInstance()->getConfigBundle('Abc');
	}

	/**
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testWrongPath() {
		$this->expectException(FatalErrorException::class);
		Builder::getInstance()->getConfigBundle(ArticlesDataTables::class);
	}

}
