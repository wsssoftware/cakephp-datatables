<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\Table\Option\Section;

use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use DataTables\Plugin;
use DataTables\Table\Builder;
use DataTables\Table\Option\MainOption;
use InvalidArgumentException;
use TestApp\Application;
use TestApp\DataTables\CategoriesDataTables;

/**
 * Class LanguageOptionTraitTest
 * Created by allancarvalho in abril 30, 2020
 */
class LanguageOptionTraitTest extends TestCase {

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
	public function testSetLanguageInfoFiltered() {
		$this->MainOption->setLanguageInfoFiltered('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageInfoFiltered());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageAriaPaginatePrevious() {
		$this->MainOption->setLanguageAriaPaginatePrevious('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageAriaPaginatePrevious());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageAriaPaginateFirst() {
		$this->MainOption->setLanguageAriaPaginateFirst('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageAriaPaginateFirst());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageInfo() {
		$this->MainOption->setLanguageInfo('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageInfo());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageLoadingRecords() {
		$this->MainOption->setLanguageLoadingRecords('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageLoadingRecords());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageSearchPlaceholder() {
		$this->MainOption->setLanguageSearchPlaceholder('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageSearchPlaceholder());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageAriaPaginateLast() {
		$this->MainOption->setLanguageAriaPaginateLast('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageAriaPaginateLast());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageInfoEmpty() {
		$this->MainOption->setLanguageInfoEmpty('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageInfoEmpty());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageDecimal() {
		$this->MainOption->setLanguageDecimal('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageDecimal());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageThousands() {
		$this->MainOption->setLanguageThousands('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageThousands());
	}

	/**
	 * @return void
	 */
	public function testSetLanguagePaginateNext() {
		$this->MainOption->setLanguagePaginateNext('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguagePaginateNext());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageAriaSortDescending() {
		$this->MainOption->setLanguageAriaSortDescending('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageAriaSortDescending());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageSearch() {
		$this->MainOption->setLanguageSearch('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageSearch());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageInfoPostFix() {
		$this->MainOption->setLanguageInfoPostFix('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageInfoPostFix());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageAriaPaginateNext() {
		$this->MainOption->setLanguageAriaPaginateNext('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageAriaPaginateNext());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageAriaSortAscending() {
		$this->MainOption->setLanguageAriaSortAscending('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageAriaSortAscending());
	}

	/**
	 * @return void
	 */
	public function testSetLanguagePaginateFirst() {
		$this->MainOption->setLanguagePaginateFirst('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguagePaginateFirst());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageUrl() {
		$this->MainOption->setLanguageUrl('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageUrl());
		$this->MainOption->setLanguageUrl([
			'controller' => 'Provider',
			'action' => 'getI18nTranslation',
			'plugin' => 'DataTables',
			'prefix' => false,
		]);
		$this->assertEquals('/data-tables/provider/get-i18n-translation', $this->MainOption->getLanguageUrl());
		$this->MainOption->setLanguageUrl(MainOption::I18N_TRANSLATION);
		$this->assertEquals('/data-tables/provider/get-i18n-translation', $this->MainOption->getLanguageUrl());
		$this->expectException(InvalidArgumentException::class);
		$this->MainOption->setLanguageUrl(true);
	}

	/**
	 * @return void
	 */
	public function testSetLanguageLengthMenu() {
		$this->MainOption->setLanguageLengthMenu('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageLengthMenu());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageZeroRecords() {
		$this->MainOption->setLanguageZeroRecords('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageZeroRecords());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageEmptyTable() {
		$this->MainOption->setLanguageEmptyTable('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageEmptyTable());
	}

	/**
	 * @return void
	 */
	public function testSetLanguagePaginateLast() {
		$this->MainOption->setLanguagePaginateLast('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguagePaginateLast());
	}

	/**
	 * @return void
	 */
	public function testSetLanguageProcessing() {
		$this->MainOption->setLanguageProcessing('abc');
		$this->assertEquals('abc', $this->MainOption->getLanguageProcessing());
	}

}
