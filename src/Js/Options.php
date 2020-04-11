<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Js;

use Cake\Error\FatalErrorException;
use Cake\Utility\Hash;
use DataTables\Tools\Tools;
use InvalidArgumentException;

/**
 * Class Options
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class Options {

	/**
	 * The options that was set and/or must be printed.
	 *
	 * @var array
	 */
	private $_mustPrint = [
		'serverSide',
	];

	/**
	 * Define if all options will be printed or not.
	 *
	 * @var bool
	 */
	private $_printAllOptions = false;

	/**
	 * DataTables Js configs
	 *
	 * @var array
	 */
	private $_config = [
		'autoWidth' => true,
		'deferRender' => false,
		'info' => true,
		'lengthChange' => true,
		'ordering' => true,
		'paging' => true,
		'processing' => false,
		'scrollX' => null,
		'searching' => true,
		'serverSide' => true,
		'stateSave' => false,
		'deferLoading' => null,
		'destroy' => false,
		'displayStart' => 0,
		'dom' => 'lfrtip',
		'lengthMenu' => [10, 25, 50, 100],
	];

	/**
	 * Options constructor.
	 */
	public function __construct() {
	}

	/**
	 * Get if all options will be printed or not.
	 *
	 * @return bool
	 */
	public function isPrintAllOptions(): bool {
		return $this->_printAllOptions;
	}

	/**
	 * Define if all options will be printed or not.
	 *
	 * @param bool $printAllOptions
	 * @return void
	 */
	public function setPrintAllOptions(bool $printAllOptions): void {
		$this->_printAllOptions = $printAllOptions;
	}

	/**
	 * Checker method.
	 * Enable or disable automatic column width calculation. This can be disabled as an optimisation(it takes a finite
	 * amount of time to calculate the widths) if the tables widths are passed in using.
	 *
	 * @link https://datatables.net/reference/option/autoWidth
	 * @return bool
	 */
	public function isAutoWidth(): bool {
		return Hash::get($this->_config, 'autoWidth');
	}

	/**
	 * Setter method.
	 * Enable or disable automatic column width calculation. This can be disabled as an optimisation(it takes a finite
	 * amount of time to calculate the widths) if the tables widths are passed in using.
	 *
	 * @param bool $autoWidth
	 * @return void
	 * @link https://datatables.net/reference/option/autoWidth
	 */
	public function setAutoWidth(bool $autoWidth): void {
		$this->_config = Hash::insert($this->_config, 'autoWidth', $autoWidth);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'autoWidth', true);
	}

	/**
	 * Checker method.
	 * By default, when DataTables loads data from an Ajax or Javascript data source (ajax and data respectively) it
	 * will create all HTML elements needed up-front. When working with large data sets, this operation can take a
	 * not-insignificant amount of time, particularly in older browsers such as IE6-8. This option allows DataTables to
	 * create the nodes (rows and cells in the table body) only when they are needed for a draw.
	 *
	 * As an example to help illustrate this, if you load a data set with 10,000 rows, but a paging display length of
	 * only 10 records, rather than create all 10,000 rows, when deferred rendering is enabled, DataTables will create
	 * only 10. When the end user then sorts, pages or filters the data the rows needed for the next display will be
	 * created automatically. This effectively spreads the load of creating the rows across the life time of the page.
	 *
	 * Note that when enabled, it goes without saying that not all nodes will always be available in the table, so when
	 * working with API methods such as columns().nodes() you must take this into account. Below shows an example of
	 * how to use jQuery delegated events to handle such a situation.
	 *
	 * @link https://datatables.net/reference/option/deferRender
	 * @return bool
	 */
	public function isDeferRender(): bool {
		return Hash::get($this->_config, 'deferRender');
	}

	/**
	 * Setter method.
	 * By default, when DataTables loads data from an Ajax or Javascript data source (ajax and data respectively) it
	 * will create all HTML elements needed up-front. When working with large data sets, this operation can take a
	 * not-insignificant amount of time, particularly in older browsers such as IE6-8. This option allows DataTables to
	 * create the nodes (rows and cells in the table body) only when they are needed for a draw.
	 *
	 * As an example to help illustrate this, if you load a data set with 10,000 rows, but a paging display length of
	 * only 10 records, rather than create all 10,000 rows, when deferred rendering is enabled, DataTables will create
	 * only 10. When the end user then sorts, pages or filters the data the rows needed for the next display will be
	 * created automatically. This effectively spreads the load of creating the rows across the life time of the page.
	 *
	 * Note that when enabled, it goes without saying that not all nodes will always be available in the table, so when
	 * working with API methods such as columns().nodes() you must take this into account. Below shows an example of
	 * how to use jQuery delegated events to handle such a situation.
	 *
	 * @param bool $deferRender
	 * @return void
	 * @link https://datatables.net/reference/option/deferRender
	 */
	public function setDeferRender(bool $deferRender): void {
		$this->_config = Hash::insert($this->_config, 'deferRender', $deferRender);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'deferRender', true);
	}

	/**
	 * Checker method.
	 * When this option is enabled, Datatables will show information about the table including information about
	 * filtered data if that action is being performed. This option allows that feature to be enabled or disabled.
	 *
	 * Note that by default the information display is shown below the table on the left, but this can be controlled
	 * using dom and CSS).
	 *
	 * @link https://datatables.net/reference/option/info
	 * @return bool
	 */
	public function isInfo(): bool {
		return Hash::get($this->_config, 'info');
	}

	/**
	 * Setter method.
	 * When this option is enabled, Datatables will show information about the table including information about
	 * filtered data if that action is being performed. This option allows that feature to be enabled or disabled.
	 *
	 * Note that by default the information display is shown below the table on the left, but this can be controlled
	 * using dom and CSS).
	 *
	 * @param bool $info
	 * @return void
	 * @link https://datatables.net/reference/option/info
	 */
	public function setInfo(bool $info): void {
		$this->_config = Hash::insert($this->_config, 'info', $info);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'info', true);
	}

	/**
	 * Checker method.
	 * When pagination is enabled, this option will control the display of an option for the end user to change the
	 * number of records to be shown per page. The options shown in the list are controlled by the lengthMenu
	 * configuration option.
	 *
	 * Note that by default the control is shown at the top left of the table. That can be controlled using dom and
	 * CSS.
	 *
	 * If this option is disabled (false) the length change input control is removed - although the page.len() method
	 * can still be used if you wish to programmatically change the page size and pageLength can be used to specify the
	 * initial page length. Paging itself is not affected.
	 *
	 * Additionally, if pagination is disabled using the paging option, this option is automatically disabled since it
	 * has no relevance when there is no pagination.
	 *
	 * @link https://datatables.net/reference/option/lengthChange
	 * @return bool
	 */
	public function isLengthChange(): bool {
		return Hash::get($this->_config, 'lengthChange');
	}

	/**
	 * Setter method.
	 * When pagination is enabled, this option will control the display of an option for the end user to change the
	 * number of records to be shown per page. The options shown in the list are controlled by the lengthMenu
	 * configuration option.
	 *
	 * Note that by default the control is shown at the top left of the table. That can be controlled using dom and
	 * CSS.
	 *
	 * If this option is disabled (false) the length change input control is removed - although the page.len() method
	 * can still be used if you wish to programmatically change the page size and pageLength can be used to specify the
	 * initial page length. Paging itself is not affected.
	 *
	 * Additionally, if pagination is disabled using the paging option, this option is automatically disabled since it
	 * has no relevance when there is no pagination.
	 *
	 * @param bool $lengthChange
	 * @return void
	 * @link https://datatables.net/reference/option/lengthChange
	 */
	public function setLengthChange(bool $lengthChange): void {
		$this->_config = Hash::insert($this->_config, 'lengthChange', $lengthChange);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'lengthChange', true);
	}

	/**
	 * Checker method.
	 * Enable or disable ordering of columns - it is as simple as that! DataTables, by default, allows end users to
	 * click on the header cell for each column, ordering the table by the data in that column. The ability to order
	 * data can be disabled using this option.
	 *
	 * Note that the ability to add or remove sorting of individual columns can be disabled by the columns.orderable
	 * option for each column. This parameter is a global option - when disabled, there are no sorting actions applied
	 * by DataTables at all.
	 *
	 * @link https://datatables.net/reference/option/ordering
	 * @return bool
	 */
	public function isOrdering(): bool {
		return Hash::get($this->_config, 'ordering');
	}

	/**
	 * Setter method.
	 * Enable or disable ordering of columns - it is as simple as that! DataTables, by default, allows end users to
	 * click on the header cell for each column, ordering the table by the data in that column. The ability to order
	 * data can be disabled using this option.
	 *
	 * Note that the ability to add or remove sorting of individual columns can be disabled by the columns.orderable
	 * option for each column. This parameter is a global option - when disabled, there are no sorting actions applied
	 * by DataTables at all.
	 *
	 * @param bool $ordering
	 * @return void
	 * @link https://datatables.net/reference/option/ordering
	 */
	public function setOrdering(bool $ordering): void {
		$this->_config = Hash::insert($this->_config, 'ordering', $ordering);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'ordering', true);
	}

	/**
	 * Checker method.
	 * DataTables can split the rows in tables into individual pages, which is an efficient method of showing a large
	 * number of records in a small space. The end user is provided with controls to request the display of different
	 * data as the navigate through the data. This feature is enabled by default, but if you wish to disable it, you
	 * may do so with this parameter.
	 *
	 * @link https://datatables.net/reference/option/paging
	 * @return bool
	 */
	public function isPaging(): bool {
		return Hash::get($this->_config, 'paging');
	}

	/**
	 * Setter method.
	 * DataTables can split the rows in tables into individual pages, which is an efficient method of showing a large
	 * number of records in a small space. The end user is provided with controls to request the display of different
	 * data as the navigate through the data. This feature is enabled by default, but if you wish to disable it, you
	 * may do so with this parameter.
	 *
	 * @param bool $paging
	 * @return void
	 * @link https://datatables.net/reference/option/paging
	 */
	public function setPaging(bool $paging): void {
		$this->_config = Hash::insert($this->_config, 'paging', $paging);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'paging', true);
	}

	/**
	 * Checker method.
	 * Enable or disable the display of a 'processing' indicator when the table is being processed (e.g. a sort). This
	 * is particularly useful for tables with large amounts of data where it can take a noticeable amount of time to
	 * sort the entries.
	 *
	 * @link https://datatables.net/reference/option/processing
	 * @return bool
	 */
	public function isProcessing(): bool {
		return Hash::get($this->_config, 'processing');
	}

	/**
	 * Setter method.
	 * Enable or disable the display of a 'processing' indicator when the table is being processed (e.g. a sort). This
	 * is particularly useful for tables with large amounts of data where it can take a noticeable amount of time to
	 * sort the entries.
	 *
	 * @param bool $processing
	 * @return void
	 * @link https://datatables.net/reference/option/processing
	 */
	public function setProcessing(bool $processing): void {
		$this->_config = Hash::insert($this->_config, 'processing', $processing);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'processing', true);
	}

	/**
	 * Checker method.
	 * Enable horizontal scrolling. When a table is too wide to fit into a certain layout, or you have a large number
	 * of columns in the table, you can enable horizontal (x) scrolling to show the table in a viewport, which can be
	 * scrolled.
	 *
	 * This property can be true which will allow the table to scroll horizontally when needed (recommended), or any
	 * CSS unit, or a number (in which case it will be treated as a pixel measurement).
	 *
	 * @link https://datatables.net/reference/option/scrollX
	 * @return bool
	 */
	public function isScrollX(): bool {
		return Hash::get($this->_config, 'scrollX');
	}

	/**
	 * Setter method.
	 * Enable horizontal scrolling. When a table is too wide to fit into a certain layout, or you have a large number
	 * of columns in the table, you can enable horizontal (x) scrolling to show the table in a viewport, which can be
	 * scrolled.
	 *
	 * This property can be true which will allow the table to scroll horizontally when needed (recommended), or any
	 * CSS unit, or a number (in which case it will be treated as a pixel measurement).
	 *
	 * @param bool $scrollX
	 * @return void
	 * @link https://datatables.net/reference/option/scrollX
	 */
	public function setScrollX(bool $scrollX): void {
		$this->_config = Hash::insert($this->_config, 'scrollX', $scrollX);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'scrollX', true);
	}

	/**
	 * Getter method.
	 * Enable vertical scrolling. Vertical scrolling will constrain the DataTable to the given height, and enable
	 * scrolling for any data which overflows the current viewport. This can be used as an alternative to paging to
	 * display a lot of data in a small area (although paging and scrolling can both be enabled at the same time if
	 * desired).
	 *
	 * The value given here can be any CSS unit, or a number (in which case it will be treated as a pixel measurement)
	 * and is applied to the table body (i.e. it does not take into account the header or footer height directly).
	 *
	 * @link https://datatables.net/reference/option/scrollY
	 * @return string
	 */
	public function getScrollY(): ?string {
		return Hash::get($this->_config, 'scrollY');
	}

	/**
	 * Setter method.
	 * Enable vertical scrolling. Vertical scrolling will constrain the DataTable to the given height, and enable
	 * scrolling for any data which overflows the current viewport. This can be used as an alternative to paging to
	 * display a lot of data in a small area (although paging and scrolling can both be enabled at the same time if
	 * desired).
	 *
	 * The value given here can be any CSS unit, or a number (in which case it will be treated as a pixel measurement)
	 * and is applied to the table body (i.e. it does not take into account the header or footer height directly).
	 *
	 * @param string $scrollY
	 * @return void
	 * @link https://datatables.net/reference/option/scrollY
	 */
	public function setScrollY(?string $scrollY): void {
		$this->_config = Hash::insert($this->_config, 'scrollY', $scrollY);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'scrollY', true);
	}

	/**
	 * Checker method.
	 * This option allows the search abilities of DataTables to be enabled or disabled. Searching in DataTables is
	 * "smart" in that it allows the end user to input multiple words (space separated) and will match a row containing
	 * those words, even if not in the order that was specified (this allow matching across multiple columns).
	 *
	 * Please be aware that technically the search in DataTables is actually a filter, since it is subtractive,
	 * removing data from the data set as the input becomes more complex. It is named "search" here, and else where in
	 * the DataTables API for consistency and to ensure there are no conflicts with other methods of a similar name
	 * (specific the filter() API method).
	 *
	 * Note that if you wish to use the search abilities of DataTables this must remain true - to remove the default
	 * search input box whilst retaining searching abilities (for example you might use the search() method), use the
	 * dom option.
	 *
	 * @link https://datatables.net/reference/option/searching
	 * @return bool
	 */
	public function isSearching(): bool {
		return Hash::get($this->_config, 'searching');
	}

	/**
	 * Setter method.
	 * This option allows the search abilities of DataTables to be enabled or disabled. Searching in DataTables is
	 * "smart" in that it allows the end user to input multiple words (space separated) and will match a row containing
	 * those words, even if not in the order that was specified (this allow matching across multiple columns).
	 *
	 * Please be aware that technically the search in DataTables is actually a filter, since it is subtractive,
	 * removing data from the data set as the input becomes more complex. It is named "search" here, and else where in
	 * the DataTables API for consistency and to ensure there are no conflicts with other methods of a similar name
	 * (specific the filter() API method).
	 *
	 * Note that if you wish to use the search abilities of DataTables this must remain true - to remove the default
	 * search input box whilst retaining searching abilities (for example you might use the search() method), use the
	 * dom option.
	 *
	 * @param bool $searching
	 * @return void
	 * @link https://datatables.net/reference/option/searching
	 */
	public function setSearching(bool $searching): void {
		$this->_config = Hash::insert($this->_config, 'searching', $searching);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'searching', true);
	}

	/**
	 * Checker method.
	 * DataTables has two fundamental modes of operation:
	 *  - Client-side processing - where filtering, paging and sorting calculations are all performed in the
	 *    web-browser.
	 *  - Server-side processing - where filtering, paging and sorting calculations are all performed by a server.
	 *
	 * By default DataTables operates in client-side processing mode, but can be switched to server-side processing
	 * mode using this option. Server-side processing is useful when working with large data sets (typically >50'000
	 * records) as it means a database engine can be used to perform the sorting etc calculations - operations that
	 * modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions
	 * of rows).
	 *
	 * When operating in server-side processing mode, DataTables will send parameters to the server indicating what
	 * data it needs (what page, what filters are applied etc), and also expects certain parameters back in order that
	 * it has all the information required to display the table. The client-server communication protocol DataTables
	 * uses is detailed in the DataTables documentation.
	 *
	 * @link https://datatables.net/reference/option/serverSide
	 * @return bool
	 */
	public function isServerSide(): bool {
		return Hash::get($this->_config, 'serverSide');
	}

	/**
	 * Setter method.
	 * DataTables has two fundamental modes of operation:
	 *  - Client-side processing - where filtering, paging and sorting calculations are all performed in the
	 *    web-browser.
	 *  - Server-side processing - where filtering, paging and sorting calculations are all performed by a server.
	 *
	 * By default DataTables operates in client-side processing mode, but can be switched to server-side processing
	 * mode using this option. Server-side processing is useful when working with large data sets (typically >50'000
	 * records) as it means a database engine can be used to perform the sorting etc calculations - operations that
	 * modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions
	 * of rows).
	 *
	 * When operating in server-side processing mode, DataTables will send parameters to the server indicating what
	 * data it needs (what page, what filters are applied etc), and also expects certain parameters back in order that
	 * it has all the information required to display the table. The client-server communication protocol DataTables
	 * uses is detailed in the DataTables documentation.
	 *
	 * @param bool $serverSide
	 * @return void
	 * @link https://datatables.net/reference/option/serverSide
	 */
	public function setServerSide(bool $serverSide): void {
		throw new FatalErrorException("By the plugin business rule, you can't change this option.");
		//$this->_config = Hash::insert($this->_config, 'serverSide', $serverSide);
		//$this->_mustPrint = Hash::insert($this->_mustPrint, 'serverSide', true);
	}

	/**
	 * Checker method.
	 * Enable or disable state saving. When enabled aDataTables will store state information such as pagination
	 * position, display length, filtering and sorting. When the end user reloads the page the table's state will be
	 * altered to match what they had previously set up.
	 *
	 * Data storage for the state information in the browser is performed by use of the localStorage or sessionStorage
	 * HTML5 APIs. The stateDuration indicated to DataTables which API should be used (localStorage: 0 or greater, or
	 * sessionStorage: -1).
	 *
	 * To be able to uniquely identify each table's state data, information is stored using a combination of the
	 * table's DOM id and the current page's pathname. If the table's id changes, or the page URL changes, the state
	 * information will be lost.
	 *
	 * Please note that the use of the HTML5 APIs for data storage means that the built in state saving option will not
	 * work with IE6/7 as these browsers do not support these APIs. Alternative options of using cookies or saving the
	 * state on the server through Ajax can be used through the stateSaveCallback and stateLoadCallback options.
	 *
	 * @link https://datatables.net/reference/option/stateSave
	 * @return bool
	 */
	public function isStateSave(): bool {
		return Hash::get($this->_config, 'stateSave');
	}

	/**
	 * Setter method.
	 * Enable or disable state saving. When enabled aDataTables will store state information such as pagination
	 * position, display length, filtering and sorting. When the end user reloads the page the table's state will be
	 * altered to match what they had previously set up.
	 *
	 * Data storage for the state information in the browser is performed by use of the localStorage or sessionStorage
	 * HTML5 APIs. The stateDuration indicated to DataTables which API should be used (localStorage: 0 or greater, or
	 * sessionStorage: -1).
	 *
	 * To be able to uniquely identify each table's state data, information is stored using a combination of the
	 * table's DOM id and the current page's pathname. If the table's id changes, or the page URL changes, the state
	 * information will be lost.
	 *
	 * Please note that the use of the HTML5 APIs for data storage means that the built in state saving option will not
	 * work with IE6/7 as these browsers do not support these APIs. Alternative options of using cookies or saving the
	 * state on the server through Ajax can be used through the stateSaveCallback and stateLoadCallback options.
	 *
	 * @param bool $stateSave
	 * @return void
	 * @link https://datatables.net/reference/option/stateSave
	 */
	public function setStateSave(bool $stateSave): void {
		$this->_config = Hash::insert($this->_config, 'stateSave', $stateSave);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'stateSave', true);
	}

	/**
	 * Getter method.
	 * When using server-side processing, the default mode of operation for DataTables is to simply throw away any data
	 * that currently exists in the table and make a request to the server to get the first page of data to display.
	 * This is fine for an empty table, but if you already have the first page of data displayed in the plain HTML, it
	 * is a waste of resources. As such, this option exists to allow you to instruct DataTables to not make that
	 * initial request, rather it will use the data already on the page (no sorting etc will be applied to it).
	 *
	 * deferLoading is used to indicate that deferred loading is required, but it is also used to tell DataTables how
	 * many records there are in the full table (allowing the information element and pagination to be displayed
	 * correctly). In the case where a filtering is applied to the table on initial load, this can be indicated by
	 * giving the parameter as an array, where the first element is the number of records available after filtering and
	 * the second element is the number of records without filtering (allowing the table information element to be
	 * shown correctly).
	 *
	 * Note that this option only has effect when serverSide is enabled. It does not have any effect when using
	 * client-side processing.
	 *
	 * Types:
	 *  - integer: When given as an integer, this enables deferred loading, and instructs DataTables as to how many
	 *    items are in the full data set.
	 *  - array: As an array, this also enables deferred loading, while the first data index tells DataTables how many
	 *    rows are in the filtered result set, and the second how many in the full data set without filtering applied.
	 *
	 * @link https://datatables.net/reference/option/deferLoading
	 * @return int|array
	 */
	public function getDeferLoading() {
		return Hash::get($this->_config, 'deferLoading');
	}

	/**
	 * Setter method.
	 * When using server-side processing, the default mode of operation for DataTables is to simply throw away any data
	 * that currently exists in the table and make a request to the server to get the first page of data to display.
	 * This is fine for an empty table, but if you already have the first page of data displayed in the plain HTML, it
	 * is a waste of resources. As such, this option exists to allow you to instruct DataTables to not make that
	 * initial request, rather it will use the data already on the page (no sorting etc will be applied to it).
	 *
	 * deferLoading is used to indicate that deferred loading is required, but it is also used to tell DataTables how
	 * many records there are in the full table (allowing the information element and pagination to be displayed
	 * correctly). In the case where a filtering is applied to the table on initial load, this can be indicated by
	 * giving the parameter as an array, where the first element is the number of records available after filtering and
	 * the second element is the number of records without filtering (allowing the table information element to be
	 * shown correctly).
	 *
	 * Note that this option only has effect when serverSide is enabled. It does not have any effect when using
	 * client-side processing.
	 *
	 * Types:
	 *  - integer: When given as an integer, this enables deferred loading, and instructs DataTables as to how many
	 *    items are in the full data set.
	 *  - array: As an array, this also enables deferred loading, while the first data index tells DataTables how many
	 *    rows are in the filtered result set, and the second how many in the full data set without filtering applied.
	 *
	 * @param int|array $deferLoading
	 * @return void
	 * @link https://datatables.net/reference/option/deferLoading
	 */
	public function setDeferLoading($deferLoading): void {
		$type = getType($deferLoading);
		if (!in_array($type, ['array', 'integer'])) {
			throw new FatalErrorException("You must use only integer or array types on \$deferLoading. Found: '$type'.");
		}
		if ($type === 'array') {
			$count = count($deferLoading);
			if ($count !== 2) {
				throw new InvalidArgumentException("\$deferLoading array must have two integers records. Found: '$count'.");
			}
			Tools::getInstance()->checkKeysValueTypesOrFail($deferLoading, 'integer', 'integer', '$deferLoading');
		}

		$this->_config = Hash::insert($this->_config, 'deferLoading', $deferLoading);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'deferLoading', true);
	}

	/**
	 * Checker method.
	 * Initialise a new DataTable as usual, but if there is an existing DataTable which matches the selector, it will
	 * be destroyed and replaced with the new table. This can be useful if you want to change a property of the table
	 * which cannot be altered through the API.
	 *
	 * Note that if you are not changing the configuration of the table, but just altering the data displayed by the
	 * table, it is far more efficient to use the ajax.reload() method (or rows.add() etc).
	 *
	 * @link https://datatables.net/reference/option/destroy
	 * @return bool
	 */
	public function isDestroy(): bool {
		return Hash::get($this->_config, 'destroy');
	}

	/**
	 * Setter method.
	 * Initialise a new DataTable as usual, but if there is an existing DataTable which matches the selector, it will
	 * be destroyed and replaced with the new table. This can be useful if you want to change a property of the table
	 * which cannot be altered through the API.
	 *
	 * Note that if you are not changing the configuration of the table, but just altering the data displayed by the
	 * table, it is far more efficient to use the ajax.reload() method (or rows.add() etc).
	 *
	 * @param bool $destroy
	 * @return void
	 * @link https://datatables.net/reference/option/destroy
	 */
	public function setDestroy(bool $destroy): void {
		$this->_config = Hash::insert($this->_config, 'destroy', $destroy);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'destroy', true);
	}

	/**
	 * Getter method.
	 * Define the starting point for data display when using DataTables with pagination (paging).
	 *
	 * Note that this parameter is the number of records (counting from 0), rather than the page number, so if you have
	 * 10 records per page and want to start on the third page, it should be 20 rather than 2 or 3.
	 *
	 * @link https://datatables.net/reference/option/displayStart
	 * @return bool
	 */
	public function getDisplayStart(): bool {
		return Hash::get($this->_config, 'displayStart');
	}

	/**
	 * Setter method.
	 * Define the starting point for data display when using DataTables with pagination (paging).
	 *
	 * Note that this parameter is the number of records (counting from 0), rather than the page number, so if you have
	 * 10 records per page and want to start on the third page, it should be 20 rather than 2 or 3.
	 *
	 * @param int $displayStart
	 * @return void
	 * @link https://datatables.net/reference/option/displayStart
	 */
	public function setDisplayStart(int $displayStart): void {
		$this->_config = Hash::insert($this->_config, 'displayStart', $displayStart);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'displayStart', true);
	}

	/**
	 * Getter method.
	 * DataTables will add a number of elements around the table to both control the table and show additional
	 * information about it. The position of these elements on screen are controlled by a combination of their order in
	 * the document (DOM) and the CSS applied to the elements. This parameter is used to control their ordering and
	 * additional mark-up surrounding them in the DOM.
	 *
	 * Each table control element in DataTables has a single letter associated with it, and that letter it used in this
	 * dom configuration option to indicate where that element will appear in the document order.
	 *
	 * The built-in table control elements in DataTables are:
	 *  - l - length changing input control
	 *  - f - filtering input
	 *  - t - The table!
	 *  - i - Table information summary
	 *  - p - pagination control
	 *  - r - processing display element
	 *
	 * @link https://datatables.net/reference/option/dom
	 * @return bool
	 */
	public function getDom(): bool {
		return Hash::get($this->_config, 'dom');
	}

	/**
	 * Setter method.
	 * Define the starting point for data display when using DataTables with pagination (paging).
	 *
	 * Note that this parameter is the number of records (counting from 0), rather than the page number, so if you have
	 * 10 records per page and want to start on the third page, it should be 20 rather than 2 or 3.
	 *
	 * @param string $dom
	 * @return void
	 * @link https://datatables.net/reference/option/dom
	 */
	public function setDom(string $dom): void {
		$this->_config = Hash::insert($this->_config, 'dom', $dom);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'dom', true);
	}

	/**
	 * Getter method.
	 * DataTables will add a number of elements around the table to both control the table and show additional
	 * information about it. The position of these elements on screen are controlled by a combination of their order in
	 * the document (DOM) and the CSS applied to the elements. This parameter is used to control their ordering and
	 * additional mark-up surrounding them in the DOM.
	 *
	 * Each table control element in DataTables has a single letter associated with it, and that letter it used in this
	 * dom configuration option to indicate where that element will appear in the document order.
	 *
	 * The built-in table control elements in DataTables are:
	 *  - l - length changing input control
	 *  - f - filtering input
	 *  - t - The table!
	 *  - i - Table information summary
	 *  - p - pagination control
	 *  - r - processing display element
	 *
	 * @link https://datatables.net/reference/option/lengthMenu
	 * @return bool
	 */
	public function getLengthMenu(): bool {
		return Hash::get($this->_config, 'lengthMenu');
	}

	/**
	 * Setter method.
	 * This parameter allows you to readily specify the entries in the length drop down select list that DataTables
	 * shows when pagination is enabled. It can be either:
	 *  - 1D array of integer values which will be used for both the displayed option and the value to use for the
	 *    display length, or
	 *  - 2D array which will use the first inner array as the page length values and the second inner array as the
	 *    displayed options. This is useful for language strings such as 'All').
	 *
	 * The page length values must always be integer values > 0, with the sole exception of -1. When -1 is used as a
	 * value this tells DataTables to disable pagination (i.e. display all rows).
	 *
	 * Note that the pageLength property will be automatically set to the first value given in this array, unless
	 * pageLength is also provided.
	 *
	 * @param array $lengthMenu
	 * @return void
	 * @link https://datatables.net/reference/option/lengthMenu
	 */
	public function setLengthMenu(array $lengthMenu): void {
		if (count($lengthMenu) === 2 && is_array($lengthMenu[array_key_first($lengthMenu)]) && is_array($lengthMenu[array_key_last($lengthMenu)])) {
			Tools::getInstance()->checkKeysValueTypesOrFail($lengthMenu[array_key_first($lengthMenu)], 'integer', 'integer', '$lengthMenu[options]');
			Tools::getInstance()->checkKeysValueTypesOrFail($lengthMenu[array_key_last($lengthMenu)], 'integer', ['integer', 'string'], '$lengthMenu[optionsLabel]');
			if (count($lengthMenu[array_key_first($lengthMenu)]) !== count($lengthMenu[array_key_last($lengthMenu)])) {
				throw new FatalErrorException('$lengthMenu[options] and $lengthMenu[optionsLabel] must have the same size.');
			}
		} else {
			Tools::getInstance()->checkKeysValueTypesOrFail($lengthMenu, 'integer', 'integer', '$lengthMenu');
		}
		$this->_config = Hash::insert($this->_config, 'lengthMenu', $lengthMenu);
		$this->_mustPrint = Hash::insert($this->_mustPrint, 'lengthMenu', true);
	}

}
