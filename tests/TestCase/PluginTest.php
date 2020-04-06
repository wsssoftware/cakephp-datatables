<?php
/**
 * Copyright (c) Allan Carvalho 2019.
 * Under Mit License
 * php version 7.2
 *
 * @category CakePHP
 * @package  DataRenderer\Core
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-data-renderer/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-data-renderer
 */

namespace DataTables\Test\TestCase;

use Cake\Core\Configure;
use Cake\Http\MiddlewareQueue;
use DataTables\Plugin;
use PHPUnit\Framework\TestCase;
use TestApp\Application;

class PluginTest extends TestCase {

	/**
	 * @return void
	 */
	public function testMiddleware() {
		$plugin = new Plugin();
		$middlewareQueue = new MiddlewareQueue();

		$response = $plugin->middleware($middlewareQueue);

		$this->assertInstanceOf(MiddlewareQueue::class, $response);
	}

	/**
	 * @return void
	 */
	public function testRoutes() {
		$this->markTestSkipped();
	}

	/**
	 * @return void
	 */
	public function testBootstrap() {
		$plugin = new Plugin();
		$baseApplication = new Application('');
		$plugin->bootstrap($baseApplication);

		$this->assertEquals(true, Configure::check('DataTables'));
	}

}
