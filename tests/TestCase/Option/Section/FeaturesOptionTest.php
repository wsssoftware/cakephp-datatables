<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\Option\Section;

use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Option\MainOption;

class FeaturesOptionTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \DataTables\Option\MainOption
	 */
	protected $MainOption;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$this->MainOption = new MainOption();
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
		$autoWidth = $this->MainOption->Features->isAutoWidth();
		$this->MainOption->Features->setAutoWidth(!$autoWidth);
		$this->assertEquals(!$autoWidth, $this->MainOption->Features->isAutoWidth());

		$deferRender = $this->MainOption->Features->isDeferRender();
		$this->MainOption->Features->setDeferRender(!$deferRender);
		$this->assertEquals(!$deferRender, $this->MainOption->Features->isDeferRender());

		$info = $this->MainOption->Features->isInfo();
		$this->MainOption->Features->setInfo(!$info);
		$this->assertEquals(!$info, $this->MainOption->Features->isInfo());

		$lengthChange = $this->MainOption->Features->isLengthChange();
		$this->MainOption->Features->setLengthChange(!$lengthChange);
		$this->assertEquals(!$lengthChange, $this->MainOption->Features->isLengthChange());

		$ordering = $this->MainOption->Features->isOrdering();
		$this->MainOption->Features->setOrdering(!$ordering);
		$this->assertEquals(!$ordering, $this->MainOption->Features->isOrdering());

		$paging = $this->MainOption->Features->isPaging();
		$this->MainOption->Features->setPaging(!$paging);
		$this->assertEquals(!$paging, $this->MainOption->Features->isPaging());

		$processing = $this->MainOption->Features->isProcessing();
		$this->MainOption->Features->setProcessing(!$processing);
		$this->assertEquals(!$processing, $this->MainOption->Features->isProcessing());

		$scrollX = $this->MainOption->Features->isScrollX();
		$this->MainOption->Features->setScrollX(!$scrollX);
		$this->assertEquals(!$scrollX, $this->MainOption->Features->isScrollX());

		$scrollYOld = $this->MainOption->Features->getScrollY();
		$scrollYOldNew = '200px';
		$this->MainOption->Features->setScrollY($scrollYOldNew);
		$this->assertNotEquals($scrollYOld, $this->MainOption->Features->getScrollY());
		$this->assertEquals($scrollYOldNew, $this->MainOption->Features->getScrollY());

		$searching = $this->MainOption->Features->isSearching();
		$this->MainOption->Features->setSearching(!$searching);
		$this->assertEquals(!$searching, $this->MainOption->Features->isSearching());

		$this->assertEquals(true, $this->MainOption->Features->isServerSide());
		$this->expectException(FatalErrorException::class);
		$this->MainOption->Features->setServerSide(false);

		$stateSave = $this->MainOption->Features->isStateSave();
		$this->MainOption->Features->setStateSave(!$stateSave);
		$this->assertEquals(!$stateSave, $this->MainOption->Features->isStateSave());
	}

}
