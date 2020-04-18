<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\StorageEngine;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\StorageEngine\CacheStorageEngine;
use TestApp\Application;

/**
 * Class CacheStorageEngineTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class CacheStorageEngineTest extends TestCase {

	use IntegrationTestTrait;

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
		$this->markTestIncomplete('Not implemented yet.');
		//$this->expectException(InvalidArgumentException::class);
		//$this->Cache = new CacheStorageEngine('cache_abc');
	}

	/**
	 * @return void
	 */
	public function testSave() {
		$this->markTestIncomplete('Not implemented yet.');
		//$buildConfig = Builder::getInstance()->buildConfigBundle('Categories', 'main', md5('abc'));
		//$this->assertTrue($this->Cache->save('abc', $buildConfig));
	}

	/**
	 * @return void
	 */
	public function testRead() {
		$this->markTestIncomplete('Not implemented yet.');
		//$buildConfig = Builder::getInstance()->buildConfigBundle('Categories', 'main', md5('abc'));
		//$this->Cache->save('abc', $buildConfig);
		//$this->assertEmpty($this->Cache->read('def'));
		//$this->assertInstanceOf(ConfigBundle::class, $this->Cache->read('abc'));
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$this->markTestIncomplete('Not implemented yet.');
		//$buildConfig = Builder::getInstance()->buildConfigBundle('Categories', 'main', md5('abc'));
		//$this->Cache->save('abc', $buildConfig);
		//$this->assertTrue($this->Cache->delete('abc'));
	}

	/**
	 * @return void
	 */
	public function testExists() {
		$this->markTestIncomplete('Not implemented yet.');
		//$buildConfig = Builder::getInstance()->buildConfigBundle('Categories', 'main', md5('abc'));
		//$this->Cache->save('abc', $buildConfig);
		//$this->assertFalse($this->Cache->exists('def'));
		//$this->assertTrue($this->Cache->exists('abc'));
	}

}
