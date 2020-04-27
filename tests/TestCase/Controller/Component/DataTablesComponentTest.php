<?php
declare(strict_types = 1);

namespace DataTables\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
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
		Router::setRequest(new ServerRequest());
		$controller = new Controller(Router::getRequest(), new Response(), 'Provider', EventManager::instance(), new ComponentRegistry());
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
	 * @return void
	 * @throws \ReflectionException
	 */
	public function testInstanceOfColumns() {
		static::assertInstanceOf(Columns::class, $this->DataTables->getColumns(CategoriesDataTables::class));
	}

	/**
	 * @return void
	 * @throws \ReflectionException
	 */
	public function testInstanceOfMainOption() {
		static::assertInstanceOf(MainOption::class, $this->DataTables->getOptions(CategoriesDataTables::class));
	}

	/**
	 * @return void
	 * @throws \ReflectionException
	 */
	public function testInstanceOfQueryBaseState() {
		static::assertInstanceOf(QueryBaseState::class, $this->DataTables->getQuery(CategoriesDataTables::class));
	}

	/**
	 * @return void
	 * @throws \ReflectionException
	 */
	public function testSaveInSessionColumns() {
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		$this->DataTables->getColumns(CategoriesDataTables::class)->addNonDatabaseColumn('abc');
		EventManager::instance()->dispatch('Controller.beforeRender');
		static::assertNotEmpty(Router::getRequest()->getSession()->read("DataTables.configs.columns.$md5"));
	}

	/**
	 * @return void
	 * @throws \ReflectionException
	 */
	public function testSaveInSessionOptions() {
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		$this->DataTables->getOptions(CategoriesDataTables::class)->setProcessing(true);
		EventManager::instance()->dispatch('Controller.beforeRender');
		static::assertNotEmpty(Router::getRequest()->getSession()->read("DataTables.configs.options.$md5"));
	}

	/**
	 * @return void
	 * @throws \ReflectionException
	 */
	public function testSaveInSessionQuery() {
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$md5 = Functions::getInstance()->getConfigBundleAndUrlUniqueMd5($configBundle);
		$this->DataTables->getQuery(CategoriesDataTables::class)->where(['id' => 1]);
		EventManager::instance()->dispatch('Controller.beforeRender');
		static::assertNotEmpty(Router::getRequest()->getSession()->read("DataTables.configs.query.$md5"));
	}

}
