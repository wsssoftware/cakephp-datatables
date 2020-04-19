<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Table\ResourcesConfig;

use Cake\Utility\Text;
use Cake\View\View;
use InvalidArgumentException;

abstract class ResourcesConfigAbstract implements ResourcesConfigInterface {

	/**
	 * @var string
	 */
	private $_cssBlock = 'css';

	/**
	 * @var string
	 */
	private $_jsBlock = 'script';

	/**
	 * @var string
	 */
	private $_dataTablesVersion = '10.10.20';

	/**
	 * @var string
	 */
	private $_theme = self::THEME_BASE;

	/**
	 * @var bool
	 */
	private $_loadThemeLibrary = false;

	/**
	 * @var int
	 */
	private $_jquery = self::JQUERY_NONE;

	/**
	 * @var bool
	 */
	private $_loadPluginAutoFill = false;

	/**
	 * @var bool
	 */
	private $_loadPluginButtons = false;

	/**
	 * @var bool
	 */
	private $_loadPluginColReorder = false;

	/**
	 * @var bool
	 */
	private $_loadPluginFixedColumns = false;

	/**
	 * @var bool
	 */
	private $_loadPluginFixedHeader = false;

	/**
	 * @var bool
	 */
	private $_loadPluginKeyTable = false;

	/**
	 * @var bool
	 */
	private $_loadPluginResponsive = false;

	/**
	 * @var bool
	 */
	private $_loadPluginRowGroup = false;

	/**
	 * @var bool
	 */
	private $_loadPluginRowReorder = false;

	/**
	 * @var bool
	 */
	private $_loadPluginScroller = false;

	/**
	 * @var bool
	 */
	private $_loadPluginSearchPanes = false;

	/**
	 * @var bool
	 */
	private $_loadPluginSelect = false;

	/**
	 * Return the array with files to load in html.
	 *
	 * @return array
	 */
	private function getList(): array {
		$result = ['css' => [], 'js' => []];
		switch ($this->_jquery) {
			case static::JQUERY_1:
				$result = $this->putInArray($result, $this->getJQuery1Library());
				break;
			case static::JQUERY_3:
				$result = $this->putInArray($result, $this->getJQuery3Library());
				break;
		}
		if ($this->_theme !== static::THEME_NONE) {
			$themeFunction = static::THEME_GET_FUNCTIONS[$this->_theme];
			$result = $this->putInArray($result, $this->{$themeFunction}());
		}
		if ($this->_theme !== static::THEME_BASE && $this->_loadThemeLibrary === true) {
			$themeLibraryFunction = static::THEME_GET_LIBRARY_FUNCTIONS[$this->_theme];
			$result = $this->putInArray($result, $this->{$themeLibraryFunction}());
		}
		if ($this->isLoadPluginAutoFill()) {
			$result = $this->putInArray($result, $this->getAutoFillPlugin());
		}
		if ($this->isLoadPluginButtons()) {
			$result = $this->putInArray($result, $this->getButtonsPlugin());
		}
		if ($this->isLoadPluginColReorder()) {
			$result = $this->putInArray($result, $this->getColReorderPlugin());
		}
		if ($this->isLoadPluginFixedColumns()) {
			$result = $this->putInArray($result, $this->getFixedColumnsPlugin());
		}
		if ($this->isLoadPluginFixedHeader()) {
			$result = $this->putInArray($result, $this->getFixedHeaderPlugin());
		}
		if ($this->isLoadPluginKeyTable()) {
			$result = $this->putInArray($result, $this->getKeyTablePlugin());
		}
		if ($this->isLoadPluginResponsive()) {
			$result = $this->putInArray($result, $this->getResponsivePlugin());
		}
		if ($this->isLoadPluginRowGroup()) {
			$result = $this->putInArray($result, $this->getRowGroupPlugin());
		}
		if ($this->isLoadPluginRowReorder()) {
			$result = $this->putInArray($result, $this->getRowReorderPlugin());
		}
		if ($this->isLoadPluginScroller()) {
			$result = $this->putInArray($result, $this->getScrollerPlugin());
		}
		if ($this->isLoadPluginSearchPanes()) {
			$result = $this->putInArray($result, $this->getSearchPanesPlugin());
		}
		if ($this->isLoadPluginSelect()) {
			$result = $this->putInArray($result, $this->getSelectPlugin());
		}

		ksort($result['css']);
		ksort($result['js']);
		return $result;
	}

	/**
	 * @param array $array
	 * @param array $toPut
	 * @return array
	 */
	private function putInArray(array $array, array $toPut): array {
		if (!empty($toPut['css'])) {
			foreach ($toPut['css'] as $order => $item) {
				$array['css'][$order] = $item;
			}
		}
		if (!empty($toPut['js'])) {
			foreach ($toPut['js'] as $order => $item) {
				$array['js'][$order] = $item;
			}
		}
		if (!empty($toPut['theme'][$this->_theme])) {
			$array = $this->putInArray($array, $toPut['theme'][$this->_theme]);
		}
		return $array;
	}

	/**
	 * @param \Cake\View\View $view
	 * @return void
	 */
	public function requestLoad(View $view): void {
		$toRender = $this->getList();
		foreach ($toRender['css'] as $css) {
			$view->Html->css("DataTables.{$this->_dataTablesVersion}/$css", ['block' => $this->_cssBlock]);
		}
		foreach ($toRender['js'] as $js) {
			$view->Html->script("DataTables.{$this->_dataTablesVersion}/$js", ['block' => $this->_jsBlock]);
		}
	}

	/**
	 * @return string
	 */
	public function getCssBlock(): string {
		return $this->_cssBlock;
	}

	/**
	 * @param string $cssBlock
	 * @return void
	 */
	public function setCssBlock(string $cssBlock): void {
		$this->_cssBlock = $cssBlock;
	}

	/**
	 * @return string
	 */
	public function getDataTablesVersion(): string {
		return $this->_dataTablesVersion;
	}

	/**
	 * @param string $dataTablesVersion
	 * @return void
	 */
	public function setDataTablesVersion(string $dataTablesVersion): void {
		$this->_dataTablesVersion = $dataTablesVersion;
	}

	/**
	 * @return string
	 */
	public function getJsBlock(): string {
		return $this->_jsBlock;
	}

	/**
	 * @param string $jsBlock
	 * @return void
	 */
	public function setJsBlock(string $jsBlock): void {
		$this->_jsBlock = $jsBlock;
	}

	/**
	 * @return string
	 */
	public function getTheme(): string {
		return $this->_theme;
	}

	/**
	 * @param string $theme
	 * @return $this
	 */
	public function setTheme(string $theme): self {
		$themesText = str_replace(' and ', ' or ', Text::toList(static::VALID_THEMES));
		if (!in_array($theme, static::VALID_THEMES)) {
			throw new InvalidArgumentException("\$theme must be $themesText. Found: $theme.");
		}
		$this->_theme = $theme;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadThemeLibrary(): bool {
		return $this->_loadThemeLibrary;
	}

	/**
	 * @param bool $loadThemeLibrary
	 * @return $this
	 */
	public function setLoadThemeLibrary(bool $loadThemeLibrary): self {
		$this->_loadThemeLibrary = $loadThemeLibrary;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getJquery(): int {
		return $this->_jquery;
	}

	/**
	 * @param int $jquery
	 * @return $this
	 */
	public function setJquery(int $jquery): self {
		$statusText = str_replace(' and ', ' or ', Text::toList(static::VALID_JQUERY_STATUS));
		if (!in_array($jquery, static::VALID_JQUERY_STATUS)) {
			throw new InvalidArgumentException("\$jquery must be $statusText. Found: $jquery.");
		}
		$this->_jquery = $jquery;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginAutoFill(): bool {
		return $this->_loadPluginAutoFill;
	}

	/**
	 * @param bool $loadPluginAutoFill
	 * @return $this
	 */
	public function setLoadPluginAutoFill(bool $loadPluginAutoFill): self {
		$this->_loadPluginAutoFill = $loadPluginAutoFill;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginButtons(): bool {
		return $this->_loadPluginButtons;
	}

	/**
	 * @param bool $loadPluginButtons
	 * @return $this
	 */
	public function setLoadPluginButtons(bool $loadPluginButtons): self {
		$this->_loadPluginButtons = $loadPluginButtons;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginColReorder(): bool {
		return $this->_loadPluginColReorder;
	}

	/**
	 * @param bool $loadPluginColReorder
	 * @return $this
	 */
	public function setLoadPluginColReorder(bool $loadPluginColReorder): self {
		$this->_loadPluginColReorder = $loadPluginColReorder;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginFixedColumns(): bool {
		return $this->_loadPluginFixedColumns;
	}

	/**
	 * @param bool $loadPluginFixedColumns
	 * @return $this
	 */
	public function setLoadPluginFixedColumns(bool $loadPluginFixedColumns): self {
		$this->_loadPluginFixedColumns = $loadPluginFixedColumns;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginFixedHeader(): bool {
		return $this->_loadPluginFixedHeader;
	}

	/**
	 * @param bool $loadPluginFixedHeader
	 * @return $this
	 */
	public function setLoadPluginFixedHeader(bool $loadPluginFixedHeader): self {
		$this->_loadPluginFixedHeader = $loadPluginFixedHeader;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginKeyTable(): bool {
		return $this->_loadPluginKeyTable;
	}

	/**
	 * @param bool $loadPluginKeyTable
	 * @return $this
	 */
	public function setLoadPluginKeyTable(bool $loadPluginKeyTable): self {
		$this->_loadPluginKeyTable = $loadPluginKeyTable;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginResponsive(): bool {
		return $this->_loadPluginResponsive;
	}

	/**
	 * @param bool $loadPluginResponsive
	 * @return $this
	 */
	public function setLoadPluginResponsive(bool $loadPluginResponsive): self {
		$this->_loadPluginResponsive = $loadPluginResponsive;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginRowGroup(): bool {
		return $this->_loadPluginRowGroup;
	}

	/**
	 * @param bool $loadPluginRowGroup
	 * @return $this
	 */
	public function setLoadPluginRowGroup(bool $loadPluginRowGroup): self {
		$this->_loadPluginRowGroup = $loadPluginRowGroup;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginRowReorder(): bool {
		return $this->_loadPluginRowReorder;
	}

	/**
	 * @param bool $loadPluginRowReorder
	 * @return $this
	 */
	public function setLoadPluginRowReorder(bool $loadPluginRowReorder): self {
		$this->_loadPluginRowReorder = $loadPluginRowReorder;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginScroller(): bool {
		return $this->_loadPluginScroller;
	}

	/**
	 * @param bool $loadPluginScroller
	 * @return $this
	 */
	public function setLoadPluginScroller(bool $loadPluginScroller): self {
		$this->_loadPluginScroller = $loadPluginScroller;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginSearchPanes(): bool {
		return $this->_loadPluginSearchPanes;
	}

	/**
	 * @param bool $loadPluginSearchPanes
	 * @return $this
	 */
	public function setLoadPluginSearchPanes(bool $loadPluginSearchPanes): self {
		$this->_loadPluginSearchPanes = $loadPluginSearchPanes;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isLoadPluginSelect(): bool {
		return $this->_loadPluginSelect;
	}

	/**
	 * @param bool $loadPluginSelect
	 * @return $this
	 */
	public function setLoadPluginSelect(bool $loadPluginSelect): self {
		$this->_loadPluginSelect = $loadPluginSelect;

		return $this;
	}

}
