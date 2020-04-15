<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\StorageEngine;

use Cake\Cache\Cache;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use DataTables\Plugin;
use DataTables\StorageEngine\CacheStorageEngine;
use DataTables\Table\BuiltConfig;
use DataTables\Tools\Builder;
use InvalidArgumentException;
use TestApp\Application;
use TestApp\DataTables\Tables\CategoriesTables;

/**
 * Class CacheStorageEngineTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class CacheStorageEngineTest extends TestCase {

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
		$buildConfig = Builder::getInstance()->buildBuiltConfig(CategoriesTables::class, 'main', new View(), md5('abc'));
		$this->assertTrue($this->Cache->save('abc', $buildConfig));
	}

	/**
	 * @return void
	 */
	public function testRead() {
		$buildConfig = Builder::getInstance()->buildBuiltConfig(CategoriesTables::class, 'main', new View(), md5('abc'));
		$this->Cache->save('abc', $buildConfig);
		$this->assertEmpty($this->Cache->read('def'));
		$this->assertInstanceOf(BuiltConfig::class, $this->Cache->read('abc'));
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$buildConfig = Builder::getInstance()->buildBuiltConfig(CategoriesTables::class, 'main', new View(), md5('abc'));
		$this->Cache->save('abc', $buildConfig);
		$this->assertTrue($this->Cache->delete('abc'));
	}

	/**
	 * @return void
	 */
	public function testExists() {
		$buildConfig = Builder::getInstance()->buildBuiltConfig(CategoriesTables::class, 'main', new View(), md5('abc'));
		$this->Cache->save('abc', $buildConfig);
		$this->assertFalse($this->Cache->exists('def'));
		$this->assertTrue($this->Cache->exists('abc'));
	}

}
