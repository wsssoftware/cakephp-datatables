<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\Table\ResourcesConfig;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use DataTables\Table\ResourcesConfig\LocalResourcesConfig;

/**
 * Class LocalResourceConfigTest
 * Created by allancarvalho in abril 24, 2020
 */
class LocalResourceConfigTest extends TestCase {

	/**
	 * @var string
	 */
	private $_cssPath;

	/**
	 * @var string
	 */
	private $_jsPath;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$this->_cssPath = DATA_TABLES_WWW_ROOT . 'css' . DS . $this->getLRC()->getDataTablesVersion() . DS;
		$this->_jsPath = DATA_TABLES_WWW_ROOT . 'js' . DS . $this->getLRC()->getDataTablesVersion() . DS;
	}

	/**
	 * @return \DataTables\Table\ResourcesConfig\LocalResourcesConfig
	 */
	public function getLRC(): LocalResourcesConfig {
		return LocalResourcesConfig::getInstance(true);
	}

	/**
	 * @param array $files
	 * @return void
	 */
	private function checkIfFilesExists(array $files): void {
		if (!empty($files['css'])) {
			foreach ($files['css'] as $css) {
				$this->assertFileExists($this->_cssPath . $css);
			}
		}
		if (!empty($files['js'])) {
			foreach ($files['js'] as $js) {
				$this->assertFileExists($this->_jsPath . $js);
			}
		}
	}

	/**
	 * @return void
	 */
	public function testIsEnabled() {
		$lrc = $this->getLRC();
		static::assertEquals(true, $lrc->isEnabled());
		$lrc->setEnabled(false);
		static::assertEquals(false, $lrc->isEnabled());
	}

	/**
	 * @return void
	 */
	public function testIsAutoload() {
		$lrc = $this->getLRC();
		static::assertEquals(true, $lrc->isAutoload());
		$lrc->setAutoload(false);
		static::assertEquals(false, $lrc->isAutoload());
	}

	/**
	 * @return void
	 */
	public function testRequestLoad() {
		$lrc = $this->getLRC();
		$view = new View();
		$lrc->requestLoad($view);
		$this->assertNotEmpty($view->fetch('css'));
		$this->assertNotEmpty($view->fetch('script'));
	}

	/**
	 * @return void
	 */
	public function testRequestLoadDisabled() {
		$lrc = $this->getLRC();
		$lrc->setEnabled(false);
		$view = new View();
		$lrc->requestLoad($view);
		$this->assertEmpty($view->fetch('css'));
		$this->assertEmpty($view->fetch('script'));
	}

	/**
	 * @return void
	 */
	public function testVersion() {
		$lrc = $this->getLRC();
		$lrc->setDataTablesVersion('1.2.3');
		$this->assertEquals('1.2.3', $lrc->getDataTablesVersion());
	}

	/**
	 * @return void
	 */
	public function testJquery() {
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_NONE);
		$lrc->setJquery(LocalResourcesConfig::JQUERY_1);
		$this->checkIfFilesExists($lrc->getList());
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_NONE);
		$lrc->setJquery(LocalResourcesConfig::JQUERY_3);
		$this->checkIfFilesExists($lrc->getList());
	}

	/**
	 * @return void
	 */
	public function testTheme1() {
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_BASE);
		$this->checkIfFilesExists($lrc->getList());
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_BOOTSTRAP3);
		$lrc->setLoadThemeLibrary(true);
		$this->checkIfFilesExists($lrc->getList());
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_BOOTSTRAP4);
		$lrc->setLoadThemeLibrary(true);
		$this->checkIfFilesExists($lrc->getList());
	}

	/**
	 * @return void
	 */
	public function testTheme2() {
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_FOUNDATION);
		$lrc->setLoadThemeLibrary(true);
		$this->checkIfFilesExists($lrc->getList());
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_JQUERY_UI);
		$lrc->setLoadThemeLibrary(true);
		$this->checkIfFilesExists($lrc->getList());
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_SEMANTIC_UI);
		$lrc->setLoadThemeLibrary(true);
		$this->checkIfFilesExists($lrc->getList());
	}

	/**
	 * @return void
	 */
	public function testPlugins() {
		$lrc = $this->getLRC();
		$lrc->setTheme(LocalResourcesConfig::THEME_NONE);
		$lrc->setJquery(LocalResourcesConfig::JQUERY_NONE);
		$lrc->setLoadPluginAutoFill(true);
		$lrc->setLoadPluginButtons(true);
		$lrc->setLoadPluginColReorder(true);
		$lrc->setLoadPluginFixedColumns(true);
		$lrc->setLoadPluginFixedHeader(true);
		$lrc->setLoadPluginKeyTable(true);
		$lrc->setLoadPluginResponsive(true);
		$lrc->setLoadPluginRowGroup(true);
		$lrc->setLoadPluginRowReorder(true);
		$lrc->setLoadPluginScroller(true);
		$lrc->setLoadPluginSearchPanes(true);
		$lrc->setLoadPluginSelect(true);
		$this->checkIfFilesExists($lrc->getList());
	}

}
