<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use DataTables\Table\Column;
use DataTables\Table\Columns;
use DataTables\Table\Option\MainOption;
use DataTables\Table\QueryBaseState;
use DataTables\Tools\Functions;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

/**
 * DataTables\Controller\Component\DataTablesComponent Test Case
 */
class DataTablesComponentTest extends TestCase {

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
	 * @var \DataTables\Controller\Component\DataTablesComponent
	 */
	protected $DataTables;

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
		$controller = new Controller(new ServerRequest(), new Response(), 'Provider', EventManager::instance(), new ComponentRegistry());
		Router::setRequest($controller->getRequest());
		$controller->loadComponent('DataTables.DataTables');
		$this->DataTables = $controller->DataTables;
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->DataTables);

		parent::tearDown();
	}

	/**
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testSaveInSessionColumns() {
		$columns = $this->DataTables->getColumns(CategoriesDataTables::class);
		$this->assertInstanceOf(Columns::class, $columns);
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		$columns->addNonDatabaseColumn('abc');
		EventManager::instance()->dispatch('Controller.beforeRender');
		$this->assertNotEmpty($this->getSession()->read("DataTables.configs.columns.$md5"));
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$this->assertInstanceOf(Column::class, $configBundle->Columns->getColumn('abc'));
	}

	/**
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testSaveInSessionOptions() {
		$options = $this->DataTables->getOptions(CategoriesDataTables::class);
		static::assertInstanceOf(MainOption::class, $options);
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		$options->setProcessing(true);
		EventManager::instance()->dispatch('Controller.beforeRender');
		static::assertNotEmpty($this->getSession()->read("DataTables.configs.options.$md5"));
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$this->assertTrue($configBundle->Options->isProcessing());
	}

	/**
	 * @throws \ReflectionException
	 * @return void
	 */
	public function testSaveInSessionQuery() {
		$query = $this->DataTables->getQuery(CategoriesDataTables::class);
		static::assertInstanceOf(QueryBaseState::class, $query);
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		$query->contain(['Abc']);
		EventManager::instance()->dispatch('Controller.beforeRender');
		static::assertNotEmpty($this->getSession()->read("DataTables.configs.query.$md5"));
		$query = TableRegistry::getTableLocator()->get('Categories')->find();
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$configBundle->Query->mergeWithQuery($query);
		$this->assertTrue(isset($query->getContain()['Abc']));
	}

}
