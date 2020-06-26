<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\StorageEngine;

use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\StorageEngine\CacheStorageEngine;
use DataTables\Table\Builder;
use DataTables\Table\ConfigBundle;
use InvalidArgumentException;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

/**
 * Class CacheStorageEngineTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class CacheStorageEngineTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var string[]
	 */
	protected $fixtures = [
		'plugin.DataTables.Categories',
	];

	/**
	 * Test subject
	 *
	 * @var \DataTables\StorageEngine\CacheStorageEngine
	 */
	protected $Cache;

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
		$this->Cache = new CacheStorageEngine();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testInvalidCacheConfig() {
		$this->expectException(InvalidArgumentException::class);
		$this->Cache = new CacheStorageEngine('cache_abc');
	}

	/**
	 * @return void
	 */
	public function testSave() {
		$buildConfig = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class, false);
		$this->assertTrue($this->Cache->save('abc', $buildConfig));
	}

	/**
	 * @return void
	 */
	public function testRead() {
		$buildConfig = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class, false);
		$this->Cache->save('abc', $buildConfig);
		$this->assertEmpty($this->Cache->read('def'));
		$this->assertInstanceOf(ConfigBundle::class, $this->Cache->read('abc'));
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$buildConfig = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class, false);
		$this->Cache->save('abc', $buildConfig);
		$this->assertTrue($this->Cache->delete('abc'));
	}

	/**
	 * @return void
	 */
	public function testExists() {
		$buildConfig = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class, false);
		$this->Cache->save('abc', $buildConfig);
		$this->assertFalse($this->Cache->exists('def'));
		$this->assertTrue($this->Cache->exists('abc'));
	}

}
