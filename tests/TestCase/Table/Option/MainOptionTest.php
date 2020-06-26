<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table\Option;

use Cake\Error\FatalErrorException;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use DataTables\Tools\Minifier;
use Exception;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;
use const JSON_ERROR_NONE;

/**
 * Class MainOptionTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class MainOptionTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\Option\MainOption
	 */
	protected $MainOption;

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\Columns
	 */
	protected $Columns;

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
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class, false);
		$this->MainOption = $configBundle->Options;
		$this->Columns = $configBundle->Columns;
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->MainOption);

		parent::tearDown();
	}

	/**
	 * Check if print all options getter and setter is working
	 *
	 * @return void
	 */
	public function testPrintAllOptions() {
		$this->MainOption->setPrintAllOptions(true);
		$this->assertEquals(true, $this->MainOption->isPrintAllOptions());
		$this->MainOption->setPrintAllOptions(false);
		$this->assertEquals(false, $this->MainOption->isPrintAllOptions());
	}

	/**
	 * Check if config getter and setter is working
	 *
	 * @return void
	 */
	public function testConfigAndMustPrint() {
		$this->MainOption->setConfig('abc', true);
		$this->assertEquals(true, $this->MainOption->getConfig('abc'));
		$this->assertEquals(true, $this->MainOption->getMustPrint('abc'));

		$this->MainOption->setConfig('def', [], false);
		$this->assertEquals([], $this->MainOption->getConfig('def'));
		$this->assertEquals(false, $this->MainOption->getMustPrint('def'));

		$this->MainOption->setMustPrint('abc', false);
		$this->assertEquals(false, $this->MainOption->getMustPrint('abc'));

		$this->assertEquals('array', getType($this->MainOption->getMustPrint()));

		$this->assertNotEmpty($this->MainOption->getConfig());
	}

	/**
	 * Check if array and json getter is working
	 *
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return void
	 */
	public function testArrayJson() {
		$this->MainOption->callbackCreatedRow('console.log("ok");');

		$this->MainOption->setConfig('abc', '1234', false);
		$this->MainOption->setPrintAllOptions(true);
		$allConfig = $this->MainOption->getConfigAsArray();
		$this->MainOption->setPrintAllOptions(false);
		$config = $this->MainOption->getConfigAsArray();
		$this->assertGreaterThanOrEqual(count($config), count($allConfig));
		$this->assertEquals(true, array_key_exists('abc', $allConfig));
		$this->assertEquals(false, array_key_exists('abc', $config));

		try {
			$this->MainOption->getConfigAsJson();
		} catch (Exception $exception) {

		} finally {
			$this->assertEquals(true, json_last_error() === JSON_ERROR_NONE);
		}
	}

	/**
	 * @return void
	 */
	public function testSetColumns() {
		$this->Columns->getColumn('Categories.id')
		              ->callbackCreatedCell('alert("ok");');
		$this->Columns->addNonDatabaseColumn('action');
		$this->MainOption->setColumns($this->Columns);
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$expected = '{"ajax":{"type":"GET","url":"\/data-tables\/provider\/get-tables-data\/categories\/6666cd76f96956469e7be39d750cc7d9"},"serverSide":!0,"language":{"thousands":",","decimal":"."},"columnDefs":[{"targets":"_all"}],"columns":[{"createdCell":function(cell,cellData,rowData,rowIndex,colIndex){alert("ok")},"name":"Categories.id","title":"Id","type":"num"},{"name":"Categories.name","title":"Name","type":"string"},{"name":"Categories.created","title":"Created","type":"date"},{"name":"action","orderable":!1,"searchable":!1,"title":"Action"}]}';
		$this->assertTextContains($expected, $json);
	}

	/**
	 * @return void
	 */
	public function testSetPage() {
		$this->assertEquals(null, $this->MainOption->getCurrentPage());
		$this->MainOption->setCurrentPage(2);
		$this->assertEquals(2, $this->MainOption->getCurrentPage());
		$this->MainOption->setCurrentPage('last');
		$this->assertEquals('"last"', $this->MainOption->getCurrentPage());
		$this->expectException(FatalErrorException::class);
		$this->MainOption->setCurrentPage(true);
	}

	/**
	 * @return void
	 */
	public function testWithLink() {
		$dataTablesQuery['data-tables']['Categories'] = [
			'page' => 2,
			'search' => 'abc',
			'columns' => [
				'Categories.id' => [
					'order' => 'asc',
					'search' => 'abc',
				],
			],
		];
		Router::setRequest(new ServerRequest(['query' => $dataTablesQuery]));
		$this->MainOption->getConfigAsArray();
		$this->assertEquals(2, $this->MainOption->getCurrentPage());
		$this->assertEquals('abc', $this->MainOption->getSearchSearch());
		$this->assertNotEmpty($this->MainOption->getOrder());
		$this->assertNotEmpty($this->MainOption->getSearchCols());
	}

}
