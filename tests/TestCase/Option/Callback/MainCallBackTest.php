<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\Option\CallBack;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Option\CallBack\MainCallBack;
use DataTables\Plugin;
use InvalidArgumentException;
use TestApp\Application;

/**
 * Class MainCallBackTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class MainCallBackTest extends TestCase {

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$plugin = new Plugin();
		$plugin->bootstrap(new Application(''));
		Configure::write('DataTables.resources.templates', DATA_TABLES_TESTS . 'test_app' . DS . 'templates' . DS . 'data_tables');
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
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function testWithFile() {
		MainCallBack::destroyAllInstances();
		$createdCellCallback = MainCallBack::getInstance('createdCell', 'Categories', 'main');
		$this->assertNotEmpty($createdCellCallback->render());
	}

	/**
	 * @return void
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function testWithBody() {
		MainCallBack::destroyAllInstances();
		$createdCellCallback = MainCallBack::getInstance('createdCell', 'Categories', 'main');
		$this->assertNotEmpty($createdCellCallback->render('abc'));
	}

	/**
	 * @return void
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function testWithCache() {
		MainCallBack::destroyAllInstances();
		Configure::write('debug', false);
		$createdCellCallback = MainCallBack::getInstance('createdCell', 'Categories', 'main');
		$this->assertNotEmpty($createdCellCallback->render('abc'));
	}

	/**
	 * @return void
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function testAppTemplateNotFound() {
		MainCallBack::destroyAllInstances();
		$this->expectException(FatalErrorException::class);
		MainCallBack::getInstance('abc', 'Categories', 'main')->render();
	}

	/**
	 * @return void
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function testPluginTemplateNotFound() {
		MainCallBack::destroyAllInstances();
		$this->expectException(FatalErrorException::class);
		MainCallBack::getInstance('abc', 'Categories', 'main')->render('abc');
	}

	/**
	 * @return void
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function testInvalidBodyOrParams1() {
		MainCallBack::destroyAllInstances();
		$this->expectException(InvalidArgumentException::class);
		MainCallBack::getInstance('createdCell', 'Categories', 'main')->render(3);
	}

	/**
	 * @return void
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function testInvalidBodyOrParams2() {
		MainCallBack::destroyAllInstances();
		$this->expectException(InvalidArgumentException::class);
		MainCallBack::getInstance('createdCell', 'Categories', 'main')->render(true);
	}

}
