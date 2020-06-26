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

use Cake\Utility\Text;
use DataTables\Tools\Validator;
use InvalidArgumentException;

/**
 * Trait OptionsOptionPZTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 */
trait OptionsOptionPZTrait {

	/**
	 * Getter method.
	 * Number of rows to display on a single page when using pagination.
	 *
	 * If lengthChange is feature enabled (it is by default) then the end user will be able to override the value set
	 * here to a custom setting using a pop-up menu (see lengthMenu).
	 *
	 * @link https://datatables.net/reference/option/pageLength
	 * @return int
	 */
	public function getPageLength(): int {
		return (int)$this->_getConfig('pageLength');
	}

	/**
	 * Setter method.
	 * Number of rows to display on a single page when using pagination.
	 *
	 * If lengthChange is feature enabled (it is by default) then the end user will be able to override the value set
	 * here to a custom setting using a pop-up menu (see lengthMenu).
	 *
	 * @link https://datatables.net/reference/option/pageLength
	 * @param int $pageLength
	 * @return $this
	 */
	public function setPageLength(int $pageLength) {
		if ($pageLength <= 0) {
			throw new InvalidArgumentException("\$pageLength must be a positive integer number. Found: $pageLength.");
		}
		$this->_setConfig('pageLength', $pageLength);

		return $this;
	}

	/**
	 * Getter method.
	 * The pagination option of DataTables will display a pagination control below the table (by default, its position
	 * can be changed using dom and CSS) with buttons that the end user can use to navigate the pages of the table.
	 * Which buttons are shown in the pagination control are defined by the option given here.
	 *
	 * DataTables has six built-in paging button arrangements:
	 *  - numbers - Page number buttons only (1.10.8)
	 *  - simple - 'Previous' and 'Next' buttons only
	 *  - simple_numbers - 'Previous' and 'Next' buttons, plus page numbers
	 *  - full - 'First', 'Previous', 'Next' and 'Last' buttons
	 *  - full_numbers - 'First', 'Previous', 'Next' and 'Last' buttons, plus page numbers
	 *  - first_last_numbers - 'First' and 'Last' buttons, plus page numbers
	 *  - Further methods can be added using plug-ins.
	 *
	 * @link https://datatables.net/reference/option/pagingType
	 * @return string
	 */
	public function getPagingType(): string {
		return (string)$this->_getConfig('pagingType');
	}

	/**
	 * Setter method.
	 * The pagination option of DataTables will display a pagination control below the table (by default, its position
	 * can be changed using dom and CSS) with buttons that the end user can use to navigate the pages of the table.
	 * Which buttons are shown in the pagination control are defined by the option given here.
	 *
	 * DataTables has six built-in paging button arrangements:
	 *  - numbers - Page number buttons only (1.10.8)
	 *  - simple - 'Previous' and 'Next' buttons only
	 *  - simple_numbers - 'Previous' and 'Next' buttons, plus page numbers
	 *  - full - 'First', 'Previous', 'Next' and 'Last' buttons
	 *  - full_numbers - 'First', 'Previous', 'Next' and 'Last' buttons, plus page numbers
	 *  - first_last_numbers - 'First' and 'Last' buttons, plus page numbers
	 *  - Further methods can be added using plug-ins.
	 *
	 * @link https://datatables.net/reference/option/pagingType
	 * @param string $pagingType
	 * @return $this
	 */
	public function setPagingType(string $pagingType) {
		if (!in_array($pagingType, static::ALLOWED_PAGING_TYPES)) {
			$allowedString = str_replace(' and ', ' or ', Text::toList(static::ALLOWED_PAGING_TYPES));

			throw new InvalidArgumentException("You must use one of $allowedString. Found: $pagingType.");
		}
		$this->_setConfig('pagingType', $pagingType);

		return $this;
	}

	/**
	 * Getter method.
	 * DataTables adds complex components to your HTML page, such as the pagination control. The business logic used to
	 * calculate what information should be displayed (what buttons in the case of the pagination buttons) is core to
	 * DataTables and generally doesn't vary how the buttons are actually displayed based on the styling requirements
	 * of the page. For example the pagination buttons might be displayed as li elements in a ul list, or simply as a
	 * collection of a buttons.
	 *
	 * This ability to use different renderers, while maintaining the same core business logic, is fundamental to how
	 * DataTables provides integration options for CSS frameworks such as Bootstrap, Foundation and jQuery UI,
	 * customising the HTML it uses to fit the requirements of each framework.
	 *
	 * This parameter controls which renderers will be used. The value given will be used if such a renderer exists,
	 * otherwise the default renderer will be used. Additional renderers can be added by plug-ins.
	 *
	 * DataTables currently supports two different types of renderers:
	 *  - header - header cell renderer
	 *  - pageButton - pagination buttons
	 *
	 * This list will likely expand significantly in future versions of DataTables!
	 *
	 * @link https://datatables.net/reference/option/renderer
	 * @return string|array
	 */
	public function getRenderer() {
		return $this->_getConfig('renderer');
	}

	/**
	 * Setter method.
	 * DataTables adds complex components to your HTML page, such as the pagination control. The business logic used to
	 * calculate what information should be displayed (what buttons in the case of the pagination buttons) is core to
	 * DataTables and generally doesn't vary how the buttons are actually displayed based on the styling requirements
	 * of the page. For example the pagination buttons might be displayed as li elements in a ul list, or simply as a
	 * collection of a buttons.
	 *
	 * This ability to use different renderers, while maintaining the same core business logic, is fundamental to how
	 * DataTables provides integration options for CSS frameworks such as Bootstrap, Foundation and jQuery UI,
	 * customising the HTML it uses to fit the requirements of each framework.
	 *
	 * This parameter controls which renderers will be used. The value given will be used if such a renderer exists,
	 * otherwise the default renderer will be used. Additional renderers can be added by plug-ins.
	 *
	 * DataTables currently supports two different types of renderers:
	 *  - header - header cell renderer
	 *  - pageButton - pagination buttons
	 *
	 * This list will likely expand significantly in future versions of DataTables!
	 *
	 * @link https://datatables.net/reference/option/renderer
	 * @param string|array $renderer
	 * @return $this
	 */
	public function setRenderer($renderer) {
		$rendererType = getType($renderer);
		if (!in_array($rendererType, ['string', 'array'])) {
			throw new InvalidArgumentException("\$renderer must be a string or array. Found: $rendererType.");
		}
		if (is_array($renderer)) {
			Validator::getInstance()->checkKeysValueTypesOrFail($renderer, 'string', 'string', '$renderer');
			foreach ($renderer as $key => $item) {
				if (!in_array($key, ['header', 'pageButton'])) {
					throw new InvalidArgumentException("You can user only 'header' and/or 'pageButton'. Found: $key.");
				}
			}
		}
		$this->_setConfig('renderer', $renderer);

		return $this;
	}

	/**
	 * Checker method.
	 * Retrieve the DataTables object for the given selector. Note that if the table has already been initialised, this
	 * parameter will cause DataTables to simply return the object that has already been set up - it will not take
	 * account of any changes you might have made to the initialisation object passed to DataTables (setting this
	 *
	 * The destroy option can be used to reinitialise a table with different options if required.
	 *
	 * @link https://datatables.net/reference/option/retrieve
	 * @return bool
	 */
	public function isRetrieve(): bool {
		return (bool)$this->_getConfig('retrieve');
	}

	/**
	 * Setter method.
	 * Retrieve the DataTables object for the given selector. Note that if the table has already been initialised, this
	 * parameter will cause DataTables to simply return the object that has already been set up - it will not take
	 * account of any changes you might have made to the initialisation object passed to DataTables (setting this
	 *
	 * The destroy option can be used to reinitialise a table with different options if required.
	 *
	 * @link https://datatables.net/reference/option/retrieve
	 * @param bool $retrieve
	 * @return $this
	 */
	public function setRetrieve(bool $retrieve) {
		$this->_setConfig('retrieve', $retrieve);

		return $this;
	}

	/**
	 * Getter method.
	 * It can often be useful to have a id attribute on each tr element in a DataTable for row selection and data
	 * source identification, particularly when using events.
	 *
	 * DataTables will attempt to automatically read an id value from the data source for each row using the property
	 * defined by this option. By default it is DT_RowId but can be set to any other name. As with columns.data it can
	 * also read from a nested JSON data source by using Javascript dotted object notation (e.g. DT_RowId: 'image.id').
	 *
	 * If no id value for the row is found, the id property will not be automatically set.
	 *
	 * Any row id values that are given in the data source should match the HTML specification for what values it can
	 * take:
	 *  - The value must be unique amongst all the IDs in the element's home subtree and must contain at least one
	 *    character. The value must not contain any space characters.
	 *
	 * You may also wish to consider the CSS 2.1 specification of an identifier which is more restrictive than HTML5's
	 * and will provide maximum compatibility with jQuery:
	 *  - identifiers (including element names, classes, and IDs in selectors) can contain only the characters
	 *    [a-zA-Z0-9] and ISO 10646 characters U+00A0 and higher, plus the hyphen (-) and the underscore (_); they
	 *    cannot start with a digit, two hyphens, or a hyphen followed by a digit. Identifiers can also contain escaped
	 *    characters and any ISO 10646 character as a numeric code.
	 *
	 * @link https://datatables.net/reference/option/rowId
	 * @return string
	 */
	public function getRowId(): string {
		return (string)$this->_getConfig('rowId');
	}

	/**
	 * Setter method.
	 * It can often be useful to have a id attribute on each tr element in a DataTable for row selection and data
	 * source identification, particularly when using events.
	 *
	 * DataTables will attempt to automatically read an id value from the data source for each row using the property
	 * defined by this option. By default it is DT_RowId but can be set to any other name. As with columns.data it can
	 * also read from a nested JSON data source by using Javascript dotted object notation (e.g. DT_RowId: 'image.id').
	 *
	 * If no id value for the row is found, the id property will not be automatically set.
	 *
	 * Any row id values that are given in the data source should match the HTML specification for what values it can
	 * take:
	 *  - The value must be unique amongst all the IDs in the element's home subtree and must contain at least one
	 *    character. The value must not contain any space characters.
	 *
	 * You may also wish to consider the CSS 2.1 specification of an identifier which is more restrictive than HTML5's
	 * and will provide maximum compatibility with jQuery:
	 *  - identifiers (including element names, classes, and IDs in selectors) can contain only the characters
	 *    [a-zA-Z0-9] and ISO 10646 characters U+00A0 and higher, plus the hyphen (-) and the underscore (_); they
	 *    cannot start with a digit, two hyphens, or a hyphen followed by a digit. Identifiers can also contain escaped
	 *    characters and any ISO 10646 character as a numeric code.
	 *
	 * @link https://datatables.net/reference/option/rowId
	 * @param string $rowId
	 * @return $this
	 */
	public function setRowId(string $rowId) {
		$this->_setConfig('rowId', $rowId);

		return $this;
	}

	/**
	 * Checker method.
	 * When vertical (y) scrolling is enabled through the use of the scrollY option, DataTables will force the height
	 * of the table's viewport to the given height at all times (useful for layout). However, this can look odd when
	 * filtering data down to a small data set, and the footer is left "floating" further down. This parameter (when
	 * enabled) will cause DataTables to collapse the table's viewport when the result set fits within the given Y
	 * height.
	 *
	 * @link https://datatables.net/reference/option/scrollCollapse
	 * @return bool
	 */
	public function isScrollCollapse(): bool {
		return (bool)$this->_getConfig('scrollCollapse');
	}

	/**
	 * Setter method.
	 * When vertical (y) scrolling is enabled through the use of the scrollY option, DataTables will force the height
	 * of the table's viewport to the given height at all times (useful for layout). However, this can look odd when
	 * filtering data down to a small data set, and the footer is left "floating" further down. This parameter (when
	 * enabled) will cause DataTables to collapse the table's viewport when the result set fits within the given Y
	 * height.
	 *
	 * @link https://datatables.net/reference/option/scrollCollapse
	 * @param bool $scrollCollapse
	 * @return $this
	 */
	public function setScrollCollapse(bool $scrollCollapse) {
		$this->_setConfig('scrollCollapse', $scrollCollapse);

		return $this;
	}

	/**
	 * Checker method.
	 * Flag to indicate if the filtering should be case insensitive or not.
	 *
	 * @link https://datatables.net/reference/option/search.caseInsensitive
	 * @return bool
	 */
	public function isSearchCaseInsensitive(): bool {
		return (bool)$this->_getConfig('search.caseInsensitive');
	}

	/**
	 * Setter method.
	 * Flag to indicate if the filtering should be case insensitive or not.
	 *
	 * @link https://datatables.net/reference/option/search.caseInsensitive
	 * @param bool $caseInsensitive
	 * @return $this
	 */
	public function setSearchCaseInsensitive(bool $caseInsensitive) {
		$this->_setConfig('search.caseInsensitive', $caseInsensitive);

		return $this;
	}

	/**
	 * Checker method.
	 * Regular expressions can be used to build fantastically complex filtering terms, but also it is perfectly valid
	 * for users to enter characters such as * into the filter, so a decision needs to be made if you wish to escape
	 * regular expression special characters or not. This option controls that ability in DataTables.
	 *
	 * It is simply a flag to indicate if the search term should be interpreted as a regular expression (true) or not
	 * (false) and therefore and special regex characters escaped.
	 *
	 * @link https://datatables.net/reference/option/search.regex
	 * @return bool
	 */
	public function isSearchRegex(): bool {
		return (bool)$this->_getConfig('search.regex');
	}

	/**
	 * Setter method.
	 * Regular expressions can be used to build fantastically complex filtering terms, but also it is perfectly valid
	 * for users to enter characters such as * into the filter, so a decision needs to be made if you wish to escape
	 * regular expression special characters or not. This option controls that ability in DataTables.
	 *
	 * It is simply a flag to indicate if the search term should be interpreted as a regular expression (true) or not
	 * (false) and therefore and special regex characters escaped.
	 *
	 * @link https://datatables.net/reference/option/search.regex
	 * @param bool $regex
	 * @return $this
	 */
	public function setSearchRegex(bool $regex) {
		$this->_setConfig('search.regex', $regex);

		return $this;
	}

	/**
	 * Getter method.
	 * Search term that should be applied to the table.
	 *
	 * @link https://datatables.net/reference/option/search.search
	 * @return string
	 */
	public function getSearchSearch(): string {
		return (string)$this->_getConfig('search.search');
	}

	/**
	 * Setter method.
	 * Search term that should be applied to the table.
	 *
	 * @link https://datatables.net/reference/option/search.search
	 * @param string $search
	 * @return $this
	 */
	public function setSearchSearch(string $search) {
		$this->_setConfig('search.search', $search);

		return $this;
	}

	/**
	 * Checker method.
	 * DataTables' built-in filtering is "smart" in that it breaks the user's input into individual words and then
	 * matches those words in any position and in any order in the table (rather than simple doing a simple string
	 * compare).
	 *
	 * Although this can significantly enhance usability of the filtering feature, it uses a complex regular expression
	 * to perform this task, and as such it can interfere with a custom regular expression input if you enable that
	 * option (search.regex). As such, this option is provided to disable this smart filtering ability.
	 *
	 * @link https://datatables.net/reference/option/search.smart
	 * @return bool
	 */
	public function isSearchSmart(): bool {
		return (bool)$this->_getConfig('search.smart');
	}

	/**
	 * Setter method.
	 * DataTables' built-in filtering is "smart" in that it breaks the user's input into individual words and then
	 * matches those words in any position and in any order in the table (rather than simple doing a simple string
	 * compare).
	 *
	 * Although this can significantly enhance usability of the filtering feature, it uses a complex regular expression
	 * to perform this task, and as such it can interfere with a custom regular expression input if you enable that
	 * option (search.regex). As such, this option is provided to disable this smart filtering ability.
	 *
	 * @link https://datatables.net/reference/option/search.smart
	 * @param bool $smart
	 * @return $this
	 */
	public function setSearchSmart(bool $smart) {
		$this->_setConfig('search.smart', $smart);

		return $this;
	}

	/**
	 * Getter method.
	 * Basically the same as the search option, but in this case for individual columns, rather than the global filter,
	 * this option defined the filtering to apply to the table during initialisation.
	 *
	 * The array must be of the same size as the number of columns, and each element be an object with the parameters
	 * search, regex (optional, default false) and smart (optional, default true). null is also accepted and the
	 * default will be used. See the search documentation for more information on these parameters.
	 *
	 * @link https://datatables.net/reference/option/searchCols
	 * @return array
	 */
	public function getSearchCols(): array {
		return $this->_getConfig('searchCols');
	}

	/**
	 * Setter method.
	 * Basically the same as the search option, but in this case for individual columns, rather than the global filter,
	 * this option defined the filtering to apply to the table during initialisation.
	 *
	 * The array must be of the same size as the number of columns, and each element be an object with the parameters
	 * search, regex (optional, default false) and smart (optional, default true). null is also accepted and the
	 * default will be used. See the search documentation for more information on these parameters.
	 *
	 * @link https://datatables.net/reference/option/searchCols
	 * @param array $searchCols
	 * @return $this
	 */
	public function setSearchCols(array $searchCols) {
		Validator::getInstance()->checkKeysValueTypesOrFail($searchCols, ['integer'], ['array', 'NULL'], '$searchCols');
		foreach ($searchCols as $searchCol) {
			if ($searchCol !== null) {
				foreach ($searchCol as $key => $item) {
					$itemType = getType($item);
					if (!in_array($key, ['caseInsensitive', 'regex', 'search', 'smart'])) {
						throw new InvalidArgumentException("You can use only 'caseInsensitive', 'regex', 'search' or 'smart' param. Found: $key.");
					} elseif (in_array($key, ['caseInsensitive', 'regex', 'smart']) && $itemType !== 'boolean') {
						throw new InvalidArgumentException("$key param must be a boolean. Found: $itemType.");
					} elseif ($key === 'search' && $itemType !== 'string') {
						throw new InvalidArgumentException("$key param must be a string. Found: $itemType.");
					}
				}
			}
		}
		$this->_setConfig('searchCols', $searchCols);

		return $this;
	}

	/**
	 * Getter method.
	 * The built-in DataTables global search (by default at the top right of every DataTable) will instantly search the
	 * table on every keypress when in client-side processing mode and reduce the search call frequency automatically
	 * to 400mS when in server-side processing mode. This call frequency (throttling) can be controlled using the
	 * searchDelay parameter for both client-side and server-side processing.
	 *
	 * Being able to control the call frequency has a number of uses:
	 *  - Older browsers and slower computers can have their processing load reduced by reducing the search frequency
	 *  - Fewer table redraws while searching can be less distracting for the user
	 *  - Reduce the load on the server when using server-side processing by making fewer calls
	 *  - Conversely, you can speed up the search when using server-side processing by reducing the default of 400mS to
	 *    instant (0).
	 *
	 * As with many other parts of DataTables, it is up to yourself how you configure it to suit your needs!
	 *
	 * The value given for searchDelay is in milliseconds (mS).
	 *
	 * Please note that this option effects only the built in global search box that DataTables provides. It does not
	 * effect the search() or column().search() methods at all. If you wish to be able to throttle calls to those API
	 * methods use the utility method $.fn.dataTable.util.throttle().
	 *
	 * @link https://datatables.net/reference/option/searchDelay
	 * @return int
	 */
	public function getSearchDelay(): int {
		return (int)$this->_getConfig('searchDelay');
	}

	/**
	 * Setter method.
	 * The built-in DataTables global search (by default at the top right of every DataTable) will instantly search the
	 * table on every keypress when in client-side processing mode and reduce the search call frequency automatically
	 * to 400mS when in server-side processing mode. This call frequency (throttling) can be controlled using the
	 * searchDelay parameter for both client-side and server-side processing.
	 *
	 * Being able to control the call frequency has a number of uses:
	 *  - Older browsers and slower computers can have their processing load reduced by reducing the search frequency
	 *  - Fewer table redraws while searching can be less distracting for the user
	 *  - Reduce the load on the server when using server-side processing by making fewer calls
	 *  - Conversely, you can speed up the search when using server-side processing by reducing the default of 400mS to
	 *    instant (0).
	 *
	 * As with many other parts of DataTables, it is up to yourself how you configure it to suit your needs!
	 *
	 * The value given for searchDelay is in milliseconds (mS).
	 *
	 * Please note that this option effects only the built in global search box that DataTables provides. It does not
	 * effect the search() or column().search() methods at all. If you wish to be able to throttle calls to those API
	 * methods use the utility method $.fn.dataTable.util.throttle().
	 *
	 * @link https://datatables.net/reference/option/searchDelay
	 * @param int $searchDelay
	 * @return $this
	 */
	public function setSearchDelay(int $searchDelay) {
		if ($searchDelay < 0) {
			throw new InvalidArgumentException("\$searchDelay must be a positive integer number. Found: $searchDelay.");
		}
		$this->_setConfig('searchDelay', $searchDelay);

		return $this;
	}

	/**
	 * Getter method.
	 * Duration for which the saved state information is considered valid. After this period has elapsed the state will
	 * be returned to the default.
	 *
	 * This option is also used to indicate to DataTables if localStorage or sessionStorage should be used for storing
	 * the table's state. When set to -1 sessionStorage will be used, while for 0 or greater localStorage will be used.
	 *
	 * The difference between the two storage APIs is that sessionStorage retains data only for the current session
	 * (i..e the current browser window). For more information on these two HTML APIs please refer to the Mozilla
	 * Storage documentation.
	 *
	 * Please note that the value is given in seconds. The value 0 is a special value as it indicates that the state
	 * can be stored and retrieved indefinitely with no time limit.
	 *
	 * @link https://datatables.net/reference/option/stateDuration
	 * @return int
	 */
	public function getStateDuration(): int {
		return (int)$this->_getConfig('stateDuration');
	}

	/**
	 * Setter method.
	 * Duration for which the saved state information is considered valid. After this period has elapsed the state will
	 * be returned to the default.
	 *
	 * This option is also used to indicate to DataTables if localStorage or sessionStorage should be used for storing
	 * the table's state. When set to -1 sessionStorage will be used, while for 0 or greater localStorage will be used.
	 *
	 * The difference between the two storage APIs is that sessionStorage retains data only for the current session
	 * (i..e the current browser window). For more information on these two HTML APIs please refer to the Mozilla
	 * Storage documentation.
	 *
	 * Please note that the value is given in seconds. The value 0 is a special value as it indicates that the state
	 * can be stored and retrieved indefinitely with no time limit.
	 *
	 * @link https://datatables.net/reference/option/stateDuration
	 * @param int $stateDuration
	 * @return $this
	 */
	public function setStateDuration(int $stateDuration) {
		if ($stateDuration <= 0) {
			throw new InvalidArgumentException("\$stateDuration must be a positive integer number. Found: $stateDuration.");
		}
		$this->_setConfig('stateDuration', $stateDuration);

		return $this;
	}

	/**
	 * Getter method.
	 * An array of CSS classes that should be applied to displayed rows, in sequence. This array may be of any length,
	 * and DataTables will apply each class sequentially, looping when required.
	 *
	 * Note that by default this option will take the values determined by the $.fn.dataTable.ext.classes.stripe*
	 * options (these are odd and even by default).
	 *
	 * @link https://datatables.net/reference/option/stripeClasses
	 * @return array
	 */
	public function getStripeClasses(): array {
		return $this->_getConfig('stripeClasses');
	}

	/**
	 * Setter method.
	 * An array of CSS classes that should be applied to displayed rows, in sequence. This array may be of any length,
	 * and DataTables will apply each class sequentially, looping when required.
	 *
	 * Note that by default this option will take the values determined by the $.fn.dataTable.ext.classes.stripe*
	 * options (these are odd and even by default).
	 *
	 * @link https://datatables.net/reference/option/stripeClasses
	 * @param array $stripeClasses
	 * @return $this
	 */
	public function setStripeClasses(array $stripeClasses) {
		Validator::getInstance()->checkKeysValueTypesOrFail($stripeClasses, 'integer', 'string', '$stripeClasses');
		$this->_setConfig('stripeClasses', $stripeClasses);

		return $this;
	}

	/**
	 * Getter method.
	 * By default DataTables allows keyboard navigation of the table (sorting, paging, and filtering) by adding a
	 * tabindex attribute to the required elements. This allows the end user to tab through the controls and press the
	 * enter key to activate them, allowing the table controls to be accessible without a mouse.
	 *
	 * The default tabindex is 0, meaning that the tab follows the flow of the document. You can overrule this using
	 * this parameter if you wish. Use a value of -1 to disable built-in keyboard navigation, although this is not
	 * recommended for accessibility reasons.
	 *
	 * @link https://datatables.net/reference/option/tabIndex
	 * @return int
	 */
	public function getTabIndex(): int {
		return (int)$this->_getConfig('tabIndex');
	}

	/**
	 * Setter method.
	 * By default DataTables allows keyboard navigation of the table (sorting, paging, and filtering) by adding a
	 * tabindex attribute to the required elements. This allows the end user to tab through the controls and press the
	 * enter key to activate them, allowing the table controls to be accessible without a mouse.
	 *
	 * The default tabindex is 0, meaning that the tab follows the flow of the document. You can overrule this using
	 * this parameter if you wish. Use a value of -1 to disable built-in keyboard navigation, although this is not
	 * recommended for accessibility reasons.
	 *
	 * @link https://datatables.net/reference/option/tabIndex
	 * @param int $tabIndex
	 * @return $this
	 */
	public function setTabIndex(int $tabIndex) {
		$this->_setConfig('tabIndex', $tabIndex);

		return $this;
	}

}
