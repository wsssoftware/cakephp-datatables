<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table\Option\Section;

use Cake\Error\FatalErrorException;
use DataTables\Tools\Functions;
use DataTables\Tools\Validator;
use InvalidArgumentException;

/**
 * Trait OptionsOptionAOTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 */
trait OptionsOptionAOTrait {

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
		return $this->_getConfig('deferLoading');
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
	 * @link https://datatables.net/reference/option/deferLoading
	 * @param int|array $deferLoading
	 * @return $this
	 */
	public function setDeferLoading($deferLoading) {
		$type = getType($deferLoading);
		if (!in_array($type, ['array', 'integer'])) {
			throw new FatalErrorException("You must use only integer or array types on \$deferLoading. Found: '$type'.");
		}
		if ($type === 'array') {
			Validator::getInstance()->checkArraySizeOrFail($deferLoading, 2);
			Validator::getInstance()->checkKeysValueTypesOrFail($deferLoading, 'integer', 'integer', '$deferLoading');
		}
		$this->_setConfig('deferLoading', $deferLoading);

		return $this;
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
		return (bool)$this->_getConfig('destroy');
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
	 * @link https://datatables.net/reference/option/destroy
	 * @param bool $destroy
	 * @return $this
	 */
	public function setDestroy(bool $destroy) {
		$this->_setConfig('destroy', $destroy);

		return $this;
	}

	/**
	 * Getter method.
	 * Define the starting point for data display when using DataTables with pagination (paging).
	 *
	 * Note that this parameter is the number of records (counting from 0), rather than the page number, so if you have
	 * 10 records per page and want to start on the third page, it should be 20 rather than 2 or 3.
	 *
	 * @link https://datatables.net/reference/option/displayStart
	 * @return int
	 */
	public function getDisplayStart(): int {
		return (int)$this->_getConfig('displayStart');
	}

	/**
	 * Setter method.
	 * Define the starting point for data display when using DataTables with pagination (paging).
	 *
	 * Note that this parameter is the number of records (counting from 0), rather than the page number, so if you have
	 * 10 records per page and want to start on the third page, it should be 20 rather than 2 or 3.
	 *
	 * @link https://datatables.net/reference/option/displayStart
	 * @param int $displayStart
	 * @return $this
	 */
	public function setDisplayStart(int $displayStart) {
		$this->_setConfig('displayStart', $displayStart);

		return $this;
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
	 * @return string
	 */
	public function getDom(): string {
		return (string)$this->_getConfig('dom');
	}

	/**
	 * Setter method.
	 * Define the starting point for data display when using DataTables with pagination (paging).
	 *
	 * Note that this parameter is the number of records (counting from 0), rather than the page number, so if you have
	 * 10 records per page and want to start on the third page, it should be 20 rather than 2 or 3.
	 *
	 * @link https://datatables.net/reference/option/dom
	 * @param string $dom
	 * @return $this
	 */
	public function setDom(string $dom) {
		$this->_setConfig('dom', $dom);

		return $this;
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
	 * @return array
	 */
	public function getLengthMenu(): array {
		return $this->_getConfig('lengthMenu');
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
	 * @link https://datatables.net/reference/option/lengthMenu
	 * @param array $lengthMenu
	 * @return $this
	 */
	public function setLengthMenu(array $lengthMenu) {
		if (count($lengthMenu) === 2 && is_array($lengthMenu[Functions::getInstance()->arrayKeyFirst($lengthMenu)]) && is_array($lengthMenu[Functions::getInstance()->arrayKeyLast($lengthMenu)])) {
			Validator::getInstance()->checkKeysValueTypesOrFail($lengthMenu[Functions::getInstance()->arrayKeyFirst($lengthMenu)], 'integer', 'integer', '$lengthMenu[options]');
			Validator::getInstance()->checkKeysValueTypesOrFail($lengthMenu[Functions::getInstance()->arrayKeyLast($lengthMenu)], 'integer', ['integer', 'string'], '$lengthMenu[optionsLabel]');
			if (count($lengthMenu[Functions::getInstance()->arrayKeyFirst($lengthMenu)]) !== count($lengthMenu[Functions::getInstance()->arrayKeyLast($lengthMenu)])) {
				throw new FatalErrorException('$lengthMenu[options] and $lengthMenu[optionsLabel] must have the same size.');
			}
		} else {
			Validator::getInstance()->checkKeysValueTypesOrFail($lengthMenu, 'integer', 'integer', '$lengthMenu');
		}
		$this->_setConfig('lengthMenu', $lengthMenu);

		return $this;
	}

	/**
	 * Getter method.
	 * If ordering is enabled (ordering), then DataTables will perform a first pass order during initialisation. Using
	 * this parameter you can define which column(s) the order is performed upon, and the ordering direction. The order
	 * must be an array of arrays, each inner array comprised of two elements:
	 *  - Column index to order upon
	 *  - Direction so order to apply (asc for ascending order or desc for descending order).
	 *
	 * This 2D array structure allows a multi-column order to be defined as the initial state should it be required.
	 *
	 * @link https://datatables.net/reference/option/order
	 * @return array
	 */
	public function getOrder(): array {
		return $this->_getConfig('order');
	}

	/**
	 * Setter method.
	 * If ordering is enabled (ordering), then DataTables will perform a first pass order during initialisation. Using
	 * this parameter you can define which column(s) the order is performed upon, and the ordering direction. The order
	 * must be an array of arrays, each inner array comprised of two elements:
	 *  - Column index to order upon
	 *  - Direction so order to apply (asc for ascending order or desc for descending order).
	 *
	 * This 2D array structure allows a multi-column order to be defined as the initial state should it be required.
	 *
	 * @link https://datatables.net/reference/option/order
	 * @param array $order
	 * @return $this
	 */
	public function setOrder(array $order) {
		Validator::getInstance()->checkKeysValueTypesOrFail($order, 'integer', 'array', '$order');
		foreach ($order as $item) {
			Validator::getInstance()->checkArraySizeOrFail($item, 2, 'In setOrder($order) you must pass the index and order (asc or desc). Eg.: [0, \'asc\'].');
			Validator::getInstance()->checkKeysValueTypesOrFail($item, 'integer', ['integer', 'string'], '$order');
			$param1 = $item[Functions::getInstance()->arrayKeyFirst($item)];
			$param2 = $item[Functions::getInstance()->arrayKeyLast($item)];
			if (getType($param1) !== 'integer' || $param1 < 0) {
				throw new InvalidArgumentException("In setOrder(\$order) the index param must be a integer great or equals 0. Found: $param1.");
			}
			if (!in_array($param2, ['asc', 'desc'])) {
				throw new InvalidArgumentException("In setOrder(\$order) the order param must be asc or desc. Found: $param2.");
			}
		}
		$this->_setConfig('order', $order);

		return $this;
	}

	/**
	 * Checker method.
	 * Allows control over whether DataTables should use the top (true) unique cell that is found for a single column,
	 * or the bottom (false - default) to attach the default order listener. This is useful when using complex headers.
	 *
	 * Consider for example the following HTML header:
	 * <thead>
	 *     <tr>
	 *         <td rowspan="2">1</td>
	 *         <td>2.1</td>
	 *     </tr>
	 *     <tr>
	 *         <td>2.2</td>
	 *     </tr>
	 * </thead>
	 *
	 * In this case, when orderCellsTop is false (default) the cells 1 and 2.2 will have the order event listener
	 * applied to them. If orderCellsTop is true then 1 and 2.1 will have the order event listeners applied to them.
	 *
	 * @link https://datatables.net/reference/option/orderCellsTop
	 * @return bool
	 */
	public function isOrderCellsTop(): bool {
		return (bool)$this->_getConfig('orderCellsTop');
	}

	/**
	 * Setter method.
	 * Allows control over whether DataTables should use the top (true) unique cell that is found for a single column,
	 * or the bottom (false - default) to attach the default order listener. This is useful when using complex headers.
	 *
	 * Consider for example the following HTML header:
	 * <thead>
	 *     <tr>
	 *         <td rowspan="2">1</td>
	 *         <td>2.1</td>
	 *     </tr>
	 *     <tr>
	 *         <td>2.2</td>
	 *     </tr>
	 * </thead>
	 *
	 * In this case, when orderCellsTop is false (default) the cells 1 and 2.2 will have the order event listener
	 * applied to them. If orderCellsTop is true then 1 and 2.1 will have the order event listeners applied to them.
	 *
	 * @link https://datatables.net/reference/option/orderCellsTop
	 * @param bool $orderCellsTop
	 * @return $this
	 */
	public function setOrderCellsTop(bool $orderCellsTop) {
		$this->_setConfig('orderCellsTop', $orderCellsTop);

		return $this;
	}

	/**
	 * Checker method.
	 * DataTables highlight the columns which are used to order the content in the table's body by adding a class to
	 * the cells in that column, which in turn has CSS applied to those classes to highlight those cells.
	 *
	 * This is done by the addition of the classes sorting_1, sorting_2 and sorting_3 to the columns which are
	 * currently being ordered on. The integer value indicates the level of sorting when mutli-column sorting. If more
	 * than 3 columns are being ordered upon, the sorting_3 class is repeated.
	 *
	 * Please note that this feature can affect performance, particularly in old browsers and when there are a lot of
	 * rows to be displayed as it is manipulating a large number of DOM elements. As such, this option is available as
	 * a feature switch to allow this feature to be disabled with working with old browsers or large data sets.
	 *
	 * @link https://datatables.net/reference/option/orderClasses
	 * @return bool
	 */
	public function isOrderClasses(): bool {
		return (bool)$this->_getConfig('orderClasses');
	}

	/**
	 * Setter method.
	 * DataTables highlight the columns which are used to order the content in the table's body by adding a class to
	 * the cells in that column, which in turn has CSS applied to those classes to highlight those cells.
	 *
	 * This is done by the addition of the classes sorting_1, sorting_2 and sorting_3 to the columns which are
	 * currently being ordered on. The integer value indicates the level of sorting when mutli-column sorting. If more
	 * than 3 columns are being ordered upon, the sorting_3 class is repeated.
	 *
	 * Please note that this feature can affect performance, particularly in old browsers and when there are a lot of
	 * rows to be displayed as it is manipulating a large number of DOM elements. As such, this option is available as
	 * a feature switch to allow this feature to be disabled with working with old browsers or large data sets.
	 *
	 * @link https://datatables.net/reference/option/orderClasses
	 * @param bool $orderClasses
	 * @return $this
	 */
	public function setOrderClasses(bool $orderClasses) {
		$this->_setConfig('orderClasses', $orderClasses);

		return $this;
	}

	/**
	 * Getter method.
	 * The option works in tandem with the order option which provides an initial ordering state for the table which
	 * can then be modified by the user clicking on column headings, while the ordering specified by this option will
	 * always be applied to the table, regardless of user interaction.
	 *
	 * This fixed ordering can be applied before (pre) or after (post) the user's own ordering criteria using the two
	 * different forms of this option (array or object) described below.
	 *
	 * The values that are used to describe the ordering conditions for the table are given as two element arrays:
	 *  - Column index to order upon
	 *  - Direction so order to apply (asc for ascending order or desc for descending order).
	 *
	 * It is also possible to give a set of nested arrays (i.e. arrays in arrays) to allow multi-column ordering to be
	 * assigned.
	 *
	 * This option can be useful if you have a column (visible or hidden) which must always be sorted upon first - a
	 * priority order or index column for example, or for grouping similar rows together.
	 *
	 * @link https://datatables.net/reference/option/orderFixed
	 * @return array
	 */
	public function getOrderFixed(): array {
		return $this->_getConfig('orderFixed');
	}

	/**
	 * Setter method.
	 * The option works in tandem with the order option which provides an initial ordering state for the table which
	 * can then be modified by the user clicking on column headings, while the ordering specified by this option will
	 * always be applied to the table, regardless of user interaction.
	 *
	 * This fixed ordering can be applied before (pre) or after (post) the user's own ordering criteria using the two
	 * different forms of this option (array or object) described below.
	 *
	 * The values that are used to describe the ordering conditions for the table are given as two element arrays:
	 *  - Column index to order upon
	 *  - Direction so order to apply (asc for ascending order or desc for descending order).
	 *
	 * It is also possible to give a set of nested arrays (i.e. arrays in arrays) to allow multi-column ordering to be
	 * assigned.
	 *
	 * This option can be useful if you have a column (visible or hidden) which must always be sorted upon first - a
	 * priority order or index column for example, or for grouping similar rows together.
	 *
	 * @link https://datatables.net/reference/option/orderFixed
	 * @param array $orderFixed
	 * @return $this
	 */
	public function setOrderFixed(array $orderFixed) {
		if (getType(Functions::getInstance()->arrayKeyFirst($orderFixed)) === 'string') {
			foreach ($orderFixed as $key => $objectItem) {
				if (!in_array($key, ['pre', 'post'])) {
					throw new InvalidArgumentException("You must use only 'pre' or 'post' key for objects type. Found: $key.");
				}
				$this->checkOrderDefault($objectItem);
			}
		} else {
			$this->checkOrderDefault($orderFixed);
		}
		$this->_setConfig('orderFixed', $orderFixed);

		return $this;
	}

	/**
	 * Check if orderFixed with default params are right.
	 *
	 * @param array $orderFixed
	 * @return void
	 */
	private function checkOrderDefault(array $orderFixed) {
		Validator::getInstance()->checkKeysValueTypesOrFail($orderFixed, ['integer', 'string'], 'array', '$orderFixed');
		foreach ($orderFixed as $item) {
			Validator::getInstance()->checkArraySizeOrFail($item, 2, "In \$orderFixed you must pass the index and after the order (asc or desc). Eg.: [0, 'asc'].");
			$param1 = $item[Functions::getInstance()->arrayKeyFirst($item)];
			$param2 = $item[Functions::getInstance()->arrayKeyLast($item)];
			if (getType($param1) !== 'integer' || $param1 < 0) {
				throw new InvalidArgumentException("In \$orderFixed the index param must be a integer great or equals 0. Found: $param1.");
			}
			if (!in_array($param2, ['asc', 'desc'])) {
				throw new InvalidArgumentException("In \$orderFixed the order param must be asc or desc. Found: $param2.");
			}
		}
	}

	/**
	 * Checker method.
	 * When ordering is enabled (ordering), by default DataTables allows users to sort multiple columns by shift
	 * clicking upon the header cell for each column. Although this can be quite useful for users, it can also increase
	 * the complexity of the order, potentiality increasing the processing time of ordering the data. Therefore, this
	 * option is provided to allow this shift-click multiple column ability.
	 *
	 * Note that disabling this ability does not impede your ability as a developer to do multiple column ordering
	 * using columns.orderData, order or order(), it just disallows the user from performing their own multi-column
	 * order.
	 *
	 * @link https://datatables.net/reference/option/orderMulti
	 * @return bool
	 */
	public function isOrderMulti(): bool {
		return (bool)$this->_getConfig('orderMulti');
	}

	/**
	 * Setter method.
	 * When ordering is enabled (ordering), by default DataTables allows users to sort multiple columns by shift
	 * clicking upon the header cell for each column. Although this can be quite useful for users, it can also increase
	 * the complexity of the order, potentiality increasing the processing time of ordering the data. Therefore, this
	 * option is provided to allow this shift-click multiple column ability.
	 *
	 * Note that disabling this ability does not impede your ability as a developer to do multiple column ordering
	 * using columns.orderData, order or order(), it just disallows the user from performing their own multi-column
	 * order.
	 *
	 * @link https://datatables.net/reference/option/orderMulti
	 * @param bool $orderMulti
	 * @return $this
	 */
	public function setOrderMulti(bool $orderMulti) {
		$this->_setConfig('orderMulti', $orderMulti);

		return $this;
	}

}
