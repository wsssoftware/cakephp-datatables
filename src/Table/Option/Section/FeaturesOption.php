<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table\Option\Section;

use Cake\Error\FatalErrorException;
use DataTables\Table\Option\ChildOptionAbstract;
use DataTables\Table\Option\MainOption;

/**
 * Class FeaturesOption
 *
 * Created by allancarvalho in abril 17, 2020
 */
final class FeaturesOption extends ChildOptionAbstract {

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_mustPrint = [
		'serverSide' => true,
	];

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_config = [
		'autoWidth' => true,
		'deferRender' => false,
		'info' => true,
		'lengthChange' => true,
		'ordering' => true,
		'paging' => true,
		'processing' => false,
		'scrollX' => false,
		'scrollY' => null,
		'searching' => true,
		'serverSide' => true,
		'stateSave' => false,
	];

	/**
	 * Checker method.
	 * Enable or disable automatic column width calculation. This can be disabled as an optimisation(it takes a finite
	 * amount of time to calculate the widths) if the tables widths are passed in using.
	 *
	 * @link https://datatables.net/reference/option/autoWidth
	 * @return bool
	 */
	public function isAutoWidth(): bool {
		return (bool)$this->_getConfig('autoWidth');
	}

	/**
	 * Setter method.
	 * Enable or disable automatic column width calculation. This can be disabled as an optimisation(it takes a finite
	 * amount of time to calculate the widths) if the tables widths are passed in using.
	 *
	 * @param bool $autoWidth
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/autoWidth
	 */
	public function setAutoWidth(bool $autoWidth): MainOption {
		$this->_setConfig('autoWidth', $autoWidth);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('deferRender');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/deferRender
	 */
	public function setDeferRender(bool $deferRender): MainOption {
		$this->_setConfig('deferRender', $deferRender);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('info');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/info
	 */
	public function setInfo(bool $info): MainOption {
		$this->_setConfig('info', $info);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('lengthChange');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/lengthChange
	 */
	public function setLengthChange(bool $lengthChange): MainOption {
		$this->_setConfig('lengthChange', $lengthChange);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('ordering');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/ordering
	 */
	public function setOrdering(bool $ordering): MainOption {
		$this->_setConfig('ordering', $ordering);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('paging');
	}

	/**
	 * Setter method.
	 * DataTables can split the rows in tables into individual pages, which is an efficient method of showing a large
	 * number of records in a small space. The end user is provided with controls to request the display of different
	 * data as the navigate through the data. This feature is enabled by default, but if you wish to disable it, you
	 * may do so with this parameter.
	 *
	 * @param bool $paging
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/paging
	 */
	public function setPaging(bool $paging): MainOption {
		$this->_setConfig('paging', $paging);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('processing');
	}

	/**
	 * Setter method.
	 * Enable or disable the display of a 'processing' indicator when the table is being processed (e.g. a sort). This
	 * is particularly useful for tables with large amounts of data where it can take a noticeable amount of time to
	 * sort the entries.
	 *
	 * @param bool $processing
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/processing
	 */
	public function setProcessing(bool $processing): MainOption {
		$this->_setConfig('processing', $processing);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('scrollX');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/scrollX
	 */
	public function setScrollX(bool $scrollX): MainOption {
		$this->_setConfig('scrollX', $scrollX);

		return $this->getMainOption();
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
		return (string)$this->_getConfig('scrollY');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/scrollY
	 */
	public function setScrollY(?string $scrollY): MainOption {
		$this->_setConfig('scrollY', $scrollY);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('searching');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/searching
	 */
	public function setSearching(bool $searching): MainOption {
		$this->_setConfig('searching', $searching);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('serverSide');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/serverSide
	 */
	public function setServerSide(bool $serverSide): MainOption {
		if ($serverSide === false) {
			throw new FatalErrorException("By the plugin business rule, you can't change this option.");
		}
		$this->_setConfig('serverSide', $serverSide);

		return $this->getMainOption();
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
		return (bool)$this->_getConfig('stateSave');
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
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/stateSave
	 */
	public function setStateSave(bool $stateSave): MainOption {
		$this->_setConfig('stateSave', $stateSave);

		return $this->getMainOption();
	}

}
