<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

use DataTables\Tools\Validator;

/**
 * Class Assets
 * Created by allancarvalho in june 26, 2020
 */
class Assets {

	public const BASE_CSS_URL = [
		'prefix' => false,
		'plugin' => 'DataTables',
		'controller' => 'Assets',
		'action' => 'css',
	];
	public const BASE_SCRIPT_URL = [
		'prefix' => false,
		'plugin' => 'DataTables',
		'controller' => 'Assets',
		'action' => 'script',
	];

	public const DEFAULT_THEME = self::THEME_BASE;
	public const THEME_BASE = 'base';
	public const THEME_BOOTSTRAP3 = 'bootstrap3';
	public const THEME_BOOTSTRAP4 = 'bootstrap4';
	public const THEME_FOUNDATION = 'foundation';
	public const THEME_JQUERYUI = 'jqueryui';
	public const THEME_SEMANTICUI = 'semanticui';

	public const THEMES_ALLOWED = [
		self::THEME_BASE,
		self::THEME_BOOTSTRAP3,
		self::THEME_BOOTSTRAP4,
		self::THEME_FOUNDATION,
		self::THEME_JQUERYUI,
		self::THEME_SEMANTICUI,
	];

	public const LIBRARY_JQUERY1 = 'jquery1';
	public const LIBRARY_JQUERY3 = 'jquery3';

	public const JQUERY_ALLOWED = [
		false,
		self::LIBRARY_JQUERY1,
		self::LIBRARY_JQUERY3,
	];

	public const PLUGIN_AUTO_FILL = 'autoFill';
	public const PLUGIN_BUTTONS = 'buttons';
	public const PLUGIN_COL_REORDER = 'colReorder';
	public const PLUGIN_FIXED_COLUMNS = 'fixedColumns';
	public const PLUGIN_FIXED_HEADER = 'fixedHeader';
	public const PLUGIN_KEY_TABLE = 'keyTable';
	public const PLUGIN_RESPONSIVE = 'responsive';
	public const PLUGIN_ROW_GROUP = 'rowGroup';
	public const PLUGIN_ROW_REORDER = 'rowReorder';
	public const PLUGIN_SCROLLER = 'scroller';
	public const PLUGIN_SEARCH_PANES = 'searchPanes';
	public const PLUGIN_SELECT = 'select';

	public const VERSION_10_10_20 = '10.10.20';
	public const DEFAULT_VERSION = self::VERSION_10_10_20;
	public const ALLOWED_VERSIONS = [
		self::VERSION_10_10_20,
	];

	/**
	 * @var self
	 */
	private static $_instance;

	/**
	 * @var bool
	 */
	private $_enabled;

	/**
	 * @var bool
	 */
	private $_autoload;

	/**
	 * @var string
	 */
	private $_cssBlock;

	/**
	 * @var string
	 */
	private $_scriptBlock;

	/**
	 * @var string
	 */
	private $_dataTablesVersion;

	/**
	 * @var string
	 */
	private $_theme;

	/**
	 * @var bool
	 */
	private $_loadThemeLibrary;

	/**
	 * @var false|string
	 */
	private $_jquery;

	/**
	 * @var bool
	 */
	private $_loadPluginAutoFill;

	/**
	 * @var bool
	 */
	private $_loadPluginButtons;

	/**
	 * @var bool
	 */
	private $_loadPluginColReorder;

	/**
	 * @var bool
	 */
	private $_loadPluginFixedColumns;

	/**
	 * @var bool
	 */
	private $_loadPluginFixedHeader;

	/**
	 * @var bool
	 */
	private $_loadPluginKeyTable;

	/**
	 * @var bool
	 */
	private $_loadPluginResponsive;

	/**
	 * @var bool
	 */
	private $_loadPluginRowGroup;

	/**
	 * @var bool
	 */
	private $_loadPluginRowReorder;

	/**
	 * @var bool
	 */
	private $_loadPluginScroller;

	/**
	 * @var bool
	 */
	private $_loadPluginSearchPanes;

	/**
	 * @var bool
	 */
	private $_loadPluginSelect;

	public function __construct() {
		$this->reset();
	}

	/**
	 * Return a instance of builder object.
	 *
	 * @param bool $reset
	 * @return \DataTables\Table\Assets
	 */
	public static function getInstance(bool $reset = false) {
		if (static::$_instance === null || $reset === true) {
			static::$_instance = new self();
		}

		return static::$_instance;
	}

	/**
	 * Apply a assets instance to main instance.
	 *
	 * @param \DataTables\Table\Assets $assets
	 * @return void
	 */
	public function applyConfig(Assets $assets): void {
		$this->setEnabled($assets->isEnabled());
		$this->setAutoload($assets->isAutoload());
		$this->setCssBlock($assets->getCssBlock());
		$this->setScriptBlock($assets->getScriptBlock());
		$this->setDataTablesVersion($assets->getDataTablesVersion());
		$this->setTheme($assets->getTheme());
		$this->setLoadThemeLibrary($assets->isLoadThemeLibrary());
		$this->setJquery($assets->getJquery());
		$this->setLoadPluginAutoFill($assets->isLoadPluginAutoFill());
		$this->setLoadPluginButtons($assets->isLoadPluginButtons());
		$this->setLoadPluginColReorder($assets->isLoadPluginColReorder());
		$this->setLoadPluginFixedColumns($assets->isLoadPluginFixedColumns());
		$this->setLoadPluginFixedHeader($assets->isLoadPluginFixedHeader());
		$this->setLoadPluginKeyTable($assets->isLoadPluginKeyTable());
		$this->setLoadPluginResponsive($assets->isLoadPluginResponsive());
		$this->setLoadPluginRowGroup($assets->isLoadPluginRowGroup());
		$this->setLoadPluginRowReorder($assets->isLoadPluginRowReorder());
		$this->setLoadPluginScroller($assets->isLoadPluginScroller());
		$this->setLoadPluginSearchPanes($assets->isLoadPluginSearchPanes());
		$this->setLoadPluginSelect($assets->isLoadPluginSelect());
	}

	/**
	 * Return the assets to default state.
	 *
	 * @return $this
	 */
	public function reset() {
		$this->setEnabled(true);
		$this->setAutoload(true);
		$this->setCssBlock('css');
		$this->setScriptBlock('script');
		$this->setDataTablesVersion(static::VERSION_10_10_20);
		$this->setTheme(static::THEME_BASE);
		$this->setLoadThemeLibrary(false);
		$this->setJquery(false);
		$this->setLoadPluginAutoFill(false);
		$this->setLoadPluginButtons(false);
		$this->setLoadPluginColReorder(false);
		$this->setLoadPluginFixedColumns(false);
		$this->setLoadPluginFixedHeader(false);
		$this->setLoadPluginKeyTable(false);
		$this->setLoadPluginResponsive(false);
		$this->setLoadPluginRowGroup(false);
		$this->setLoadPluginRowReorder(false);
		$this->setLoadPluginScroller(false);
		$this->setLoadPluginSearchPanes(false);
		$this->setLoadPluginSelect(false);

		return $this;
	}

	/**
	 * Return the query for the url.
	 *
	 * @return array
	 */
	private function _getQuery(): array {
		$query = [];
		$query['version'] = $this->getDataTablesVersion();
		$query['theme'] = $this->getTheme();
		$query['library'] = $this->isLoadThemeLibrary();
		$query['jquery'] = $this->getJquery();
		$query['plugins'] = [
			static::PLUGIN_AUTO_FILL => $this->isLoadPluginAutoFill(),
			static::PLUGIN_BUTTONS => $this->isLoadPluginButtons(),
			static::PLUGIN_COL_REORDER => $this->isLoadPluginColReorder(),
			static::PLUGIN_FIXED_COLUMNS => $this->isLoadPluginFixedColumns(),
			static::PLUGIN_FIXED_HEADER => $this->isLoadPluginFixedHeader(),
			static::PLUGIN_KEY_TABLE => $this->isLoadPluginKeyTable(),
			static::PLUGIN_RESPONSIVE => $this->isLoadPluginResponsive(),
			static::PLUGIN_ROW_GROUP => $this->isLoadPluginRowGroup(),
			static::PLUGIN_ROW_REORDER => $this->isLoadPluginRowReorder(),
			static::PLUGIN_SCROLLER => $this->isLoadPluginScroller(),
			static::PLUGIN_SEARCH_PANES => $this->isLoadPluginSearchPanes(),
			static::PLUGIN_SELECT => $this->isLoadPluginSelect(),
		];

		return $query;
	}

	/**
	 * Get the css URL array.
	 *
	 * @return array
	 */
	public function getCssUrlArray(): array {
		return static::BASE_CSS_URL + [
				'?' => $this->_getQuery(),
			];
	}

	/**
	 * Get the script URL array.
	 *
	 * @return array
	 */
	public function getScriptUrlArray(): array {
		return static::BASE_SCRIPT_URL + [
				'?' => $this->_getQuery(),
			];
	}

	/**
	 * Check if assets load is enabled.
	 *
	 * @return bool
	 */
	public function isEnabled(): bool {
		return $this->_enabled;
	}

	/**
	 * Set assets load to on or off.
	 *
	 * @param bool $enabled
	 * @return $this
	 */
	public function setEnabled(bool $enabled) {
		$this->_enabled = $enabled;

		return $this;
	}

	/**
	 * Check if the plugin must autoload plugins when it needed.
	 *
	 * @return bool
	 */
	public function isAutoload(): bool {
		return $this->_autoload;
	}

	/**
	 * Set to on or off if the plugin will load a plugin when it needed.
	 *
	 * @param bool $autoload
	 * @return $this
	 */
	public function setAutoload(bool $autoload) {
		$this->_autoload = $autoload;

		return $this;
	}

	/**
	 * Get the block name that the plugin will render the css.
	 *
	 * @return string
	 */
	public function getCssBlock(): string {
		return $this->_cssBlock;
	}

	/**
	 * Set the block name that the plugin will render the css.
	 *
	 * @param string $cssBlock
	 * @return $this
	 */
	public function setCssBlock(string $cssBlock) {
		$this->_cssBlock = $cssBlock;

		return $this;
	}

	/**
	 * Get the block name that the plugin will render the script.
	 *
	 * @return string
	 */
	public function getScriptBlock(): string {
		return $this->_scriptBlock;
	}

	/**
	 * Set the block name that the plugin will render the script.
	 *
	 * @param string $scriptBlock
	 * @return $this
	 */
	public function setScriptBlock(string $scriptBlock) {
		$this->_scriptBlock = $scriptBlock;

		return $this;
	}

	/**
	 * Get the current library that will be used to load the assets.
	 *
	 * @return string
	 */
	public function getDataTablesVersion(): string {
		return $this->_dataTablesVersion;
	}

	/**
	 * Set the current library version that will be used to load the assets.
	 *
	 * @param string $dataTablesVersion
	 * @return $this
	 */
	public function setDataTablesVersion(string $dataTablesVersion) {
		Validator::getInstance()->inArrayOrFail($dataTablesVersion, static::ALLOWED_VERSIONS, false);
		$this->_dataTablesVersion = $dataTablesVersion;

		return $this;
	}

	/**
	 * Get the selected DataTables library theme.
	 *
	 * @return string
	 */
	public function getTheme(): string {
		return $this->_theme;
	}

	/**
	 * Set a theme that the DataTable library will use.
	 *
	 * @param string $theme
	 * @return $this
	 */
	public function setTheme(string $theme) {
		Validator::getInstance()->inArrayOrFail($theme, static::THEMES_ALLOWED, false);
		$this->_theme = $theme;

		return $this;
	}

	/**
	 * Get if the plugin will load the theme library if needed.
	 *
	 * @return bool
	 */
	public function isLoadThemeLibrary(): bool {
		return $this->_loadThemeLibrary;
	}

	/**
	 * Set if the plugin must to load the theme library if needed.
	 *
	 * @param bool $loadThemeLibrary
	 * @return $this
	 */
	public function setLoadThemeLibrary(bool $loadThemeLibrary) {
		$this->_loadThemeLibrary = $loadThemeLibrary;

		return $this;
	}

	/**
	 * Get the used version of jquery or false if disabled.
	 *
	 * @return string|false
	 */
	public function getJquery() {
		return $this->_jquery;
	}

	/**
	 * Set the version that the library will use of jQuery. Set false to disabled.
	 *
	 * @param string|false $jquery
	 * @return $this
	 */
	public function setJquery($jquery) {
		Validator::getInstance()->inArrayOrFail($jquery, static::JQUERY_ALLOWED, false);
		$this->_jquery = $jquery;

		return $this;
	}

	/**
	 * Check if the plugin Auto Fill is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginAutoFill(): bool {
		return $this->_loadPluginAutoFill;
	}

	/**
	 * Set if the plugin Auto Fill will be loaded.
	 *
	 * @param bool $loadPluginAutoFill
	 * @return $this
	 */
	public function setLoadPluginAutoFill(bool $loadPluginAutoFill) {
		$this->_loadPluginAutoFill = $loadPluginAutoFill;

		return $this;
	}

	/**
	 * Check if the plugin Buttons is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginButtons(): bool {
		return $this->_loadPluginButtons;
	}

	/**
	 * Set if the plugin Butttons will be loaded.
	 *
	 * @param bool $loadPluginButtons
	 * @return $this
	 */
	public function setLoadPluginButtons(bool $loadPluginButtons) {
		$this->_loadPluginButtons = $loadPluginButtons;

		return $this;
	}

	/**
	 * Check if the plugin Col Reorder is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginColReorder(): bool {
		return $this->_loadPluginColReorder;
	}

	/**
	 * Set if the plugin Col Reorder will be loaded.
	 *
	 * @param bool $loadPluginColReorder
	 * @return $this
	 */
	public function setLoadPluginColReorder(bool $loadPluginColReorder) {
		$this->_loadPluginColReorder = $loadPluginColReorder;

		return $this;
	}

	/**
	 * Check if the plugin FixedColumns is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginFixedColumns(): bool {
		return $this->_loadPluginFixedColumns;
	}

	/**
	 * Set if the plugin Fixed Columns will be loaded.
	 *
	 * @param bool $loadPluginFixedColumns
	 * @return $this
	 */
	public function setLoadPluginFixedColumns(bool $loadPluginFixedColumns) {
		$this->_loadPluginFixedColumns = $loadPluginFixedColumns;

		return $this;
	}

	/**
	 * Check if the plugin FixedHeader is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginFixedHeader(): bool {
		return $this->_loadPluginFixedHeader;
	}

	/**
	 * Set if the plugin Fixed Header will be loaded.
	 *
	 * @param bool $loadPluginFixedHeader
	 * @return $this
	 */
	public function setLoadPluginFixedHeader(bool $loadPluginFixedHeader) {
		$this->_loadPluginFixedHeader = $loadPluginFixedHeader;

		return $this;
	}

	/**
	 * Check if the plugin Key Table is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginKeyTable(): bool {
		return $this->_loadPluginKeyTable;
	}

	/**
	 * Set if the plugin Key Table will be loaded.
	 *
	 * @param bool $loadPluginKeyTable
	 * @return $this
	 */
	public function setLoadPluginKeyTable(bool $loadPluginKeyTable) {
		$this->_loadPluginKeyTable = $loadPluginKeyTable;

		return $this;
	}

	/**
	 * Check if the plugin Responsive is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginResponsive(): bool {
		return $this->_loadPluginResponsive;
	}

	/**
	 * Set if the plugin Responsive will be loaded.
	 *
	 * @param bool $loadPluginResponsive
	 * @return $this
	 */
	public function setLoadPluginResponsive(bool $loadPluginResponsive) {
		$this->_loadPluginResponsive = $loadPluginResponsive;

		return $this;
	}

	/**
	 * Check if the plugin Row Group is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginRowGroup(): bool {
		return $this->_loadPluginRowGroup;
	}

	/**
	 * Set if the plugin Row Group will be loaded.
	 *
	 * @param bool $loadPluginRowGroup
	 * @return $this
	 */
	public function setLoadPluginRowGroup(bool $loadPluginRowGroup) {
		$this->_loadPluginRowGroup = $loadPluginRowGroup;

		return $this;
	}

	/**
	 * Check if the plugin Row Reorder is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginRowReorder(): bool {
		return $this->_loadPluginRowReorder;
	}

	/**
	 * Set if the plugin Row Reorder will be loaded.
	 *
	 * @param bool $loadPluginRowReorder
	 * @return $this
	 */
	public function setLoadPluginRowReorder(bool $loadPluginRowReorder) {
		$this->_loadPluginRowReorder = $loadPluginRowReorder;

		return $this;
	}

	/**
	 * Check if the plugin Scroller is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginScroller(): bool {
		return $this->_loadPluginScroller;
	}

	/**
	 * Set if the plugin Scroller will be loaded.
	 *
	 * @param bool $loadPluginScroller
	 * @return $this
	 */
	public function setLoadPluginScroller(bool $loadPluginScroller) {
		$this->_loadPluginScroller = $loadPluginScroller;

		return $this;
	}

	/**
	 * Check if the plugin Search Panes is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginSearchPanes(): bool {
		return $this->_loadPluginSearchPanes;
	}

	/**
	 * Set if the plugin Search Panes will be loaded.
	 *
	 * @param bool $loadPluginSearchPanes
	 * @return $this
	 */
	public function setLoadPluginSearchPanes(bool $loadPluginSearchPanes) {
		$this->_loadPluginSearchPanes = $loadPluginSearchPanes;

		return $this;
	}

	/**
	 * Check if the plugin Select is loaded.
	 *
	 * @return bool
	 */
	public function isLoadPluginSelect(): bool {
		return $this->_loadPluginSelect;
	}

	/**
	 * Set if the plugin Select will be loaded.
	 *
	 * @param bool $loadPluginSelect
	 * @return $this
	 */
	public function setLoadPluginSelect(bool $loadPluginSelect) {
		$this->_loadPluginSelect = $loadPluginSelect;

		return $this;
	}

}
