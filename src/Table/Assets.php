<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types=1);

namespace DataTables\Table;

use DataTables\Tools\Validator;

/**
 * Class Assets
 * Created by allancarvalho in june 26, 2020
 */
class Assets
{
    const THEME_BASE = 'base';
    const THEME_BOOTSTRAP3 = 'bootstrap3';
    const THEME_BOOTSTRAP4 = 'bootstrap4';
    const THEME_FOUNDATION = 'foundation';
    const THEME_JQUERYUI = 'jqueryui';
    const THEME_SEMANTICUI = 'semanticui';

    const THEMES_ALLOWED = [
        self::THEME_BASE,
        self::THEME_BOOTSTRAP3,
        self::THEME_BOOTSTRAP4,
        self::THEME_FOUNDATION,
        self::THEME_JQUERYUI,
        self::THEME_SEMANTICUI
    ];

    const LIBRARY_JQUERY1 = 'jquery1';
    const LIBRARY_JQUERY3 = 'jquery3';

    const JQUERY_ALLOWED = [
        false,
        self::LIBRARY_JQUERY1,
        self::LIBRARY_JQUERY3
    ];

    const PLUGIN_AUTO_FILL = 'autoFill';
    const PLUGIN_BUTTONS = 'buttons';
    const PLUGIN_COL_REORDER = 'colReorder';
    const PLUGIN_FIXED_COLUMNS = 'fixedColumns';
    const PLUGIN_FIXED_HEADER = 'fixedHeader';
    const PLUGIN_KEY_TABLE = 'keyTable';
    const PLUGIN_RESPONSIVE = 'responsive';
    const PLUGIN_ROW_GROUP = 'rowGroup';
    const PLUGIN_ROW_REORDER = 'rowReorder';
    const PLUGIN_SCROLLER = 'scroller';
    const PLUGIN_SEARCH_PANES = 'searchPanes';
    const PLUGIN_SELECT = 'select';

    const VERSION_10_10_20 = '10.10.20';
    const ALLOWED_VERSIONS = [
        self::VERSION_10_10_20
    ];

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

    /**
     * Assets constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Return the assets to default state.
     *
     * @return \DataTables\Table\Assets
     */
    public function reset(): self
    {
        $this->setEnabled(true);
        $this->setAutoload(true);
        $this->setCssBlock('css');
        $this->setScriptBlock('script');
        $this->setDataTablesVersion(self::VERSION_10_10_20);
        $this->setTheme(self::THEME_BASE);
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
     * Check if assets load is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->_enabled;
    }

    /**
     * Set assets load to on or off.
     *
     * @param bool $enabled
     * @return \DataTables\Table\Assets
     */
    public function setEnabled(bool $enabled): self
    {
        $this->_enabled = $enabled;

        return $this;
    }

    /**
     * Check if the plugin must autoload plugins when it needed.
     *
     * @return bool
     */
    public function isAutoload(): bool
    {
        return $this->_autoload;
    }

    /**
     * Set to on or off if the plugin will load a plugin when it needed.
     *
     * @param bool $autoload
     * @return \DataTables\Table\Assets
     */
    public function setAutoload(bool $autoload): self
    {
        $this->_autoload = $autoload;

        return $this;
    }

    /**
     * Get the block name that the plugin will render the css.
     *
     * @return string
     */
    public function getCssBlock(): string
    {
        return $this->_cssBlock;
    }

    /**
     * Set the block name that the plugin will render the css.
     *
     * @param string $cssBlock
     * @return \DataTables\Table\Assets
     */
    public function setCssBlock(string $cssBlock): self
    {
        $this->_cssBlock = $cssBlock;

        return $this;
    }

    /**
     * Get the block name that the plugin will render the script.
     *
     * @return string
     */
    public function getScriptBlock(): string
    {
        return $this->_scriptBlock;
    }

    /**
     * Set the block name that the plugin will render the script.
     *
     * @param string $scriptBlock
     * @return \DataTables\Table\Assets
     */
    public function setScriptBlock(string $scriptBlock): self
    {
        $this->_scriptBlock = $scriptBlock;

        return $this;
    }

    /**
     * Get the current library that will be used to load the assets.
     *
     * @return string
     */
    public function getDataTablesVersion(): string
    {
        return $this->_dataTablesVersion;
    }

    /**
     * Set the current library version that will be used to load the assets.
     *
     * @param string $dataTablesVersion
     * @return \DataTables\Table\Assets
     */
    public function setDataTablesVersion(string $dataTablesVersion): self
    {
        Validator::getInstance()->inArrayOrFail($dataTablesVersion, self::ALLOWED_VERSIONS, false);
        $this->_dataTablesVersion = $dataTablesVersion;

        return $this;
    }

    /**
     * Get the selected DataTables library theme.
     *
     * @return string
     */
    public function getTheme(): string
    {
        return $this->_theme;
    }

    /**
     * Set a theme that the DataTable library will use.
     *
     * @param string $theme
     * @return \DataTables\Table\Assets
     */
    public function setTheme(string $theme): self
    {
        Validator::getInstance()->inArrayOrFail($theme, self::THEMES_ALLOWED, false);
        $this->_theme = $theme;

        return $this;
    }

    /**
     * Get if the plugin will load the theme library if needed.
     *
     * @return bool
     */
    public function isLoadThemeLibrary(): bool
    {
        return $this->_loadThemeLibrary;
    }

    /**
     * Set if the plugin must to load the theme library if needed.
     *
     * @param bool $loadThemeLibrary
     * @return \DataTables\Table\Assets
     */
    public function setLoadThemeLibrary(bool $loadThemeLibrary): self
    {
        $this->_loadThemeLibrary = $loadThemeLibrary;

        return $this;
    }

    /**
     * Get the used version of jquery or false if disabled.
     *
     * @return false|string
     */
    public function getJquery()
    {
        return $this->_jquery;
    }

    /**
     * Set the version that the library will use of jQuery. Set false to disabled.
     *
     * @param false|string $jquery
     * @return \DataTables\Table\Assets
     */
    public function setJquery($jquery): self
    {
        Validator::getInstance()->inArrayOrFail($jquery, self::JQUERY_ALLOWED, false);
        $this->_jquery = $jquery;

        return $this;
    }

    /**
     * Check if the plugin Auto Fill is loaded.
     *
     * @return bool
     */
    public function isLoadPluginAutoFill(): bool
    {
        return $this->_loadPluginAutoFill;
    }

    /**
     * Set if the plugin Auto Fill will be loaded.
     *
     * @param bool $loadPluginAutoFill
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginAutoFill(bool $loadPluginAutoFill): self
    {
        $this->_loadPluginAutoFill = $loadPluginAutoFill;

        return $this;
    }

    /**
     * Check if the plugin Buttons is loaded.
     *
     * @return bool
     */
    public function isLoadPluginButtons(): bool
    {
        return $this->_loadPluginButtons;
    }

    /**
     * Set if the plugin Butttons will be loaded.
     *
     * @param bool $loadPluginButtons
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginButtons(bool $loadPluginButtons): self
    {
        $this->_loadPluginButtons = $loadPluginButtons;

        return $this;
    }

    /**
     * Check if the plugin Col Reorder is loaded.
     *
     * @return bool
     */
    public function isLoadPluginColReorder(): bool
    {
        return $this->_loadPluginColReorder;
    }

    /**
     * Set if the plugin Col Reorder will be loaded.
     *
     * @param bool $loadPluginColReorder
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginColReorder(bool $loadPluginColReorder): self
    {
        $this->_loadPluginColReorder = $loadPluginColReorder;

        return $this;
    }

    /**
     * Check if the plugin FixedColumns is loaded.
     *
     * @return bool
     */
    public function isLoadPluginFixedColumns(): bool
    {
        return $this->_loadPluginFixedColumns;
    }

    /**
     * Set if the plugin Fixed Columns will be loaded.
     *
     *
     * @param bool $loadPluginFixedColumns
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginFixedColumns(bool $loadPluginFixedColumns): self
    {
        $this->_loadPluginFixedColumns = $loadPluginFixedColumns;

        return $this;
    }

    /**
     * Check if the plugin FixedHeader is loaded.
     *
     * @return bool
     */
    public function isLoadPluginFixedHeader(): bool
    {
        return $this->_loadPluginFixedHeader;
    }

    /**
     * Set if the plugin Fixed Header will be loaded.
     *
     * @param bool $loadPluginFixedHeader
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginFixedHeader(bool $loadPluginFixedHeader): self
    {
        $this->_loadPluginFixedHeader = $loadPluginFixedHeader;

        return $this;
    }

    /**
     * Check if the plugin Key Table is loaded.
     *
     * @return bool
     */
    public function isLoadPluginKeyTable(): bool
    {
        return $this->_loadPluginKeyTable;
    }

    /**
     * Set if the plugin Key Table will be loaded.
     *
     * @param bool $loadPluginKeyTable
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginKeyTable(bool $loadPluginKeyTable): self
    {
        $this->_loadPluginKeyTable = $loadPluginKeyTable;

        return $this;
    }

    /**
     * Check if the plugin Responsive is loaded.
     *
     * @return bool
     */
    public function isLoadPluginResponsive(): bool
    {
        return $this->_loadPluginResponsive;
    }

    /**
     * Set if the plugin Responsive will be loaded.
     *
     * @param bool $loadPluginResponsive
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginResponsive(bool $loadPluginResponsive): self
    {
        $this->_loadPluginResponsive = $loadPluginResponsive;

        return $this;
    }

    /**
     * Check if the plugin Row Group is loaded.
     *
     * @return bool
     */
    public function isLoadPluginRowGroup(): bool
    {
        return $this->_loadPluginRowGroup;
    }

    /**
     * Set if the plugin Row Group will be loaded.
     *
     * @param bool $loadPluginRowGroup
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginRowGroup(bool $loadPluginRowGroup): self
    {
        $this->_loadPluginRowGroup = $loadPluginRowGroup;

        return $this;
    }

    /**
     * Check if the plugin Row Reorder is loaded.
     *
     * @return bool
     */
    public function isLoadPluginRowReorder(): bool
    {
        return $this->_loadPluginRowReorder;
    }

    /**
     * Set if the plugin Row Reorder will be loaded.
     *
     * @param bool $loadPluginRowReorder
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginRowReorder(bool $loadPluginRowReorder): self
    {
        $this->_loadPluginRowReorder = $loadPluginRowReorder;

        return $this;
    }

    /**
     * Check if the plugin Scroller is loaded.
     *
     * @return bool
     */
    public function isLoadPluginScroller(): bool
    {
        return $this->_loadPluginScroller;
    }

    /**
     * Set if the plugin Scroller will be loaded.
     *
     * @param bool $loadPluginScroller
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginScroller(bool $loadPluginScroller): self
    {
        $this->_loadPluginScroller = $loadPluginScroller;

        return $this;
    }

    /**
     * Check if the plugin Search Panes is loaded.
     *
     * @return bool
     */
    public function isLoadPluginSearchPanes(): bool
    {
        return $this->_loadPluginSearchPanes;
    }

    /**
     * Set if the plugin Search Panes will be loaded.
     *
     * @param bool $loadPluginSearchPanes
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginSearchPanes(bool $loadPluginSearchPanes): self
    {
        $this->_loadPluginSearchPanes = $loadPluginSearchPanes;

        return $this;
    }

    /**
     * Check if the plugin Select is loaded.
     *
     * @return bool
     */
    public function isLoadPluginSelect(): bool
    {
        return $this->_loadPluginSelect;
    }

    /**
     * Set if the plugin Select will be loaded.
     *
     * @param bool $loadPluginSelect
     * @return \DataTables\Table\Assets
     */
    public function setLoadPluginSelect(bool $loadPluginSelect): self
    {
        $this->_loadPluginSelect = $loadPluginSelect;

        return $this;
    }


}