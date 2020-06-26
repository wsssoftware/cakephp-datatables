<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table\Option\Section;

use Cake\Error\FatalErrorException;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

/**
 * Class FeaturesOptionTraitTest
 * Created by allancarvalho in abril 24, 2020
 */
class FeaturesOptionTraitTest extends TestCase {

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
	public function testSimpleOptions() {
		$autoWidth = $this->MainOption->isAutoWidth();
		$this->MainOption->setAutoWidth(!$autoWidth);
		$this->assertEquals(!$autoWidth, $this->MainOption->isAutoWidth());

		$deferRender = $this->MainOption->isDeferRender();
		$this->MainOption->setDeferRender(!$deferRender);
		$this->assertEquals(!$deferRender, $this->MainOption->isDeferRender());

		$info = $this->MainOption->isInfo();
		$this->MainOption->setInfo(!$info);
		$this->assertEquals(!$info, $this->MainOption->isInfo());

		$lengthChange = $this->MainOption->isLengthChange();
		$this->MainOption->setLengthChange(!$lengthChange);
		$this->assertEquals(!$lengthChange, $this->MainOption->isLengthChange());

		$ordering = $this->MainOption->isOrdering();
		$this->MainOption->setOrdering(!$ordering);
		$this->assertEquals(!$ordering, $this->MainOption->isOrdering());

		$paging = $this->MainOption->isPaging();
		$this->MainOption->setPaging(!$paging);
		$this->assertEquals(!$paging, $this->MainOption->isPaging());

		$processing = $this->MainOption->isProcessing();
		$this->MainOption->setProcessing(!$processing);
		$this->assertEquals(!$processing, $this->MainOption->isProcessing());

		$scrollX = $this->MainOption->isScrollX();
		$this->MainOption->setScrollX(!$scrollX);
		$this->assertEquals(!$scrollX, $this->MainOption->isScrollX());

		$scrollYOld = $this->MainOption->getScrollY();
		$scrollYOldNew = '200px';
		$this->MainOption->setScrollY($scrollYOldNew);
		$this->assertNotEquals($scrollYOld, $this->MainOption->getScrollY());
		$this->assertEquals($scrollYOldNew, $this->MainOption->getScrollY());

		$searching = $this->MainOption->isSearching();
		$this->MainOption->setSearching(!$searching);
		$this->assertEquals(!$searching, $this->MainOption->isSearching());

		$stateSave = $this->MainOption->isStateSave();
		$this->MainOption->setStateSave(!$stateSave);
		$this->assertEquals(!$stateSave, $this->MainOption->isStateSave());

		$this->assertEquals(true, $this->MainOption->isServerSide());
		$this->MainOption->setServerSide(true);
		$this->assertEquals(true, $this->MainOption->isServerSide());
		$this->expectException(FatalErrorException::class);
		$this->MainOption->setServerSide(false);
	}

}
