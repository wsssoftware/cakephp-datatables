<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\Table\Option\Callback;

use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use DataTables\Tools\Minifier;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

/**
 * Class CallBacksTraitTest
 * Created by allancarvalho in maio 02, 2020
 */
class CallBacksTraitTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\Table\Option\MainOption
	 */
	protected $MainOption;

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
		$configBundle = Builder::getInstance()->getConfigBundle(CategoriesDataTables::class);
		$this->MainOption = $configBundle->Options;
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
	 * @return void
	 */
	public function testCallbackPreDrawCallback() {
		$this->MainOption->callbackPreDrawCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"preDrawCallback":function(settings){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackInitComplete() {
		$this->MainOption->callbackInitComplete('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"initComplete":function(settings,json){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackCreatedRow() {
		$this->MainOption->callbackCreatedRow('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"createdRow":function(row,data,dataIndex,cells){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackHeaderCallback() {
		$this->MainOption->callbackHeaderCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"headerCallback":function(thead,data,start,end,display){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackStateSaveParams() {
		$this->MainOption->callbackStateSaveParams('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"stateSaveParams":function(setting,data){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackDrawCallback() {
		$this->MainOption->callbackDrawCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"drawCallback":function(settings){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackStateLoadCallback() {
		$this->MainOption->callbackStateLoadCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"stateLoadCallback":function(setting,callback){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackStateLoadParams() {
		$this->MainOption->callbackStateLoadParams('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"stateLoadParams":function(setting,data){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackStateLoaded() {
		$this->MainOption->callbackStateLoaded('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"stateLoaded":function(setting,data){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackStateSaveCallback() {
		$this->MainOption->callbackStateSaveCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"stateSaveCallback":function(setting,data){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackFooterCallback() {
		$this->MainOption->callbackFooterCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"footerCallback":function(tfoot,data,start,end,display){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackInfoCallback() {
		$this->MainOption->callbackInfoCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"infoCallback":function(settings,start,end,max,total,pre){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackFormatNumber() {
		$this->MainOption->callbackFormatNumber('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains('"formatNumber":function(toFormat){alert("ok")}', $json);
	}

	/**
	 * @return void
	 */
	public function testCallbackRowCallback() {
		$this->MainOption->callbackRowCallback('alert("ok");');
		$json = Minifier::js($this->MainOption->getConfigAsJson());
		$this->assertTextContains(',"rowCallback":function(row,data,displayNum,displayIndex,dataIndex){alert("ok")}', $json);
	}

}
