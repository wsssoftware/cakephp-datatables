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
use Cake\Error\FatalErrorException;
use DataTables\Plugin;
use PHPUnit\Framework\TestCase;
use TestApp\Application;

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
