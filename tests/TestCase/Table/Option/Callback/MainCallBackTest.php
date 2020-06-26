<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table\Option\Callback;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Option\CallBack\CallBackFactory;
use InvalidArgumentException;
use TestApp\Application;

/**
 * Class MainCallBackTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
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
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testWithFile() {
		CallBackFactory::destroyAllInstances();
		$createdCellCallback = CallBackFactory::getInstance('createdCell', 'Categories');
		$this->assertNotEmpty($createdCellCallback->render());
	}

	/**
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testWithBody() {
		CallBackFactory::destroyAllInstances();
		$createdCellCallback = CallBackFactory::getInstance('createdCell', 'Categories');
		$this->assertNotEmpty($createdCellCallback->render('abc'));
	}

	/**
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testWithCache() {
		CallBackFactory::destroyAllInstances();
		Configure::write('debug', false);
		$createdCellCallback = CallBackFactory::getInstance('createdCell', 'Categories');
		$this->assertNotEmpty($createdCellCallback->render('abc'));
	}

	/**
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testAppTemplateNotFound() {
		CallBackFactory::destroyAllInstances();
		$this->expectException(FatalErrorException::class);
		CallBackFactory::getInstance('abc', 'Categories')->render();
	}

	/**
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testPluginTemplateNotFound() {
		CallBackFactory::destroyAllInstances();
		$this->expectException(FatalErrorException::class);
		CallBackFactory::getInstance('abc', 'Categories')->render('abc');
	}

	/**
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testInvalidBodyOrParams1() {
		CallBackFactory::destroyAllInstances();
		$this->expectException(InvalidArgumentException::class);
		CallBackFactory::getInstance('createdCell', 'Categories')->render(3);
	}

	/**
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testInvalidBodyOrParams2() {
		CallBackFactory::destroyAllInstances();
		$this->expectException(InvalidArgumentException::class);
		CallBackFactory::getInstance('createdCell', 'Categories')->render(true);
	}

}
