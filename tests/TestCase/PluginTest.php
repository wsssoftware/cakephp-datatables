<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use TestApp\Application;

/**
 * Class PluginTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class PluginTest extends TestCase {

	/**
	 * @return void
	 */
	public function testBootstrapBasic() {
		$plugin = new Plugin();
		$baseApplication = new Application('');
		Configure::write('DataTables', [
			'test1' => '123',
			'testArray' => [
				'test2' => 'abc',
			],
		]);
		$plugin->bootstrap($baseApplication);
		$this->assertEquals('123', Configure::read('DataTables.test1'));
		$this->assertEquals('abc', Configure::read('DataTables.testArray.test2'));
		$this->assertNotEmpty(Cache::getConfig('_data_tables_config_bundles_'));
	}

	/**
	 * @return void
	 */
	public function testBootstrapApplicationConfigurationException() {
		$plugin = new Plugin();
		$baseApplication = new Application('');
		Configure::write('DataTables', 'test');
		$this->expectException(FatalErrorException::class);
		$plugin->bootstrap($baseApplication);
	}

}
