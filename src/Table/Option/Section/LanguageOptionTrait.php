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

use Cake\Routing\Router;
use DataTables\Table\Option\MainOption;
use InvalidArgumentException;

/**
 * Trait LanguageOptionTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 */
trait LanguageOptionTrait {

	/**
	 * Getter method.
	 * Set the ARIA label attribute for the first pagination button. This can be particularly useful for cases where
	 * you wish to show an icon such as « in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.first
	 * @return string
	 */
	public function getLanguageAriaPaginateFirst(): ?string {
		return (string)$this->_getConfig('language.aria.paginate.first');
	}

	/**
	 * Setter method.
	 * Set the ARIA label attribute for the first pagination button. This can be particularly useful for cases where
	 * you wish to show an icon such as « in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.first
	 * @param string $ariaPaginateFirst
	 * @return $this
	 */
	public function setLanguageAriaPaginateFirst(string $ariaPaginateFirst) {
		$this->_setConfig('language.aria.paginate.first', $ariaPaginateFirst);

		return $this;
	}

	/**
	 * Getter method.
	 * Set the ARIA label attribute for the last pagination button. This can be particularly useful for cases where you
	 * wish to show an icon such as » in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.last
	 * @return string
	 */
	public function getLanguageAriaPaginateLast(): ?string {
		return (string)$this->_getConfig('language.aria.paginate.last');
	}

	/**
	 * Setter method.
	 * Set the ARIA label attribute for the last pagination button. This can be particularly useful for cases where you
	 * wish to show an icon such as » in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.last
	 * @param string $ariaPaginateLast
	 * @return $this
	 */
	public function setLanguageAriaPaginateLast(string $ariaPaginateLast) {
		$this->_setConfig('language.aria.paginate.last', $ariaPaginateLast);

		return $this;
	}

	/**
	 * Getter method.
	 * Set the ARIA label attribute for the next pagination button. This can be particularly useful for cases where you
	 * wish to show an icon such as » or › in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.next
	 * @return string
	 */
	public function getLanguageAriaPaginateNext(): ?string {
		return (string)$this->_getConfig('language.aria.paginate.next');
	}

	/**
	 * Setter method.
	 * Set the ARIA label attribute for the next pagination button. This can be particularly useful for cases where you
	 * wish to show an icon such as » or › in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.next
	 * @param string $ariaPaginateNext
	 * @return $this
	 */
	public function setLanguageAriaPaginateNext(string $ariaPaginateNext) {
		$this->_setConfig('language.aria.paginate.next', $ariaPaginateNext);

		return $this;
	}

	/**
	 * Getter method.
	 * Set the ARIA label attribute for the previous pagination button. This can be particularly useful for cases where
	 * you wish to show an icon such as « or ‹ in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.previous
	 * @return string
	 */
	public function getLanguageAriaPaginatePrevious(): ?string {
		return (string)$this->_getConfig('language.aria.paginate.previous');
	}

	/**
	 * Setter method.
	 * Set the ARIA label attribute for the previous pagination button. This can be particularly useful for cases where
	 * you wish to show an icon such as « or ‹ in the button itself, while retaining full accessibility.
	 *
	 * @link https://datatables.net/reference/option/language.aria.paginate.previous
	 * @param string $ariaPaginatePrevious
	 * @return $this
	 */
	public function setLanguageAriaPaginatePrevious(string $ariaPaginatePrevious) {
		$this->_setConfig('language.aria.paginate.previous', $ariaPaginatePrevious);

		return $this;
	}

	/**
	 * Getter method.
	 * ARIA label that is added to the table headers when the column may be sorted ascending by activating the column
	 * (click or return when focused).
	 *
	 * Note that the column header text is prefixed to this string.
	 *
	 * @link https://datatables.net/reference/option/language.aria.sortAscending
	 * @return string
	 */
	public function getLanguageAriaSortAscending(): ?string {
		return (string)$this->_getConfig('language.aria.sortAscending');
	}

	/**
	 * Setter method.
	 * ARIA label that is added to the table headers when the column may be sorted ascending by activating the column
	 * (click or return when focused).
	 *
	 * Note that the column header text is prefixed to this string.
	 *
	 * @link https://datatables.net/reference/option/language.aria.sortAscending
	 * @param string $ariaSortAscending
	 * @return $this
	 */
	public function setLanguageAriaSortAscending(string $ariaSortAscending) {
		$this->_setConfig('language.aria.sortAscending', $ariaSortAscending);

		return $this;
	}

	/**
	 * Getter method.
	 * ARIA label that is added to the table headers when the column may be sorted descending by activing the column
	 * (click or return when focused).
	 *
	 * Note that the column header text is prefixed to this string.
	 *
	 * @link https://datatables.net/reference/option/language.aria.sortDescending
	 * @return string
	 */
	public function getLanguageAriaSortDescending(): ?string {
		return (string)$this->_getConfig('language.aria.sortDescending');
	}

	/**
	 * Setter method.
	 * ARIA label that is added to the table headers when the column may be sorted descending by activing the column
	 * (click or return when focused).
	 *
	 * Note that the column header text is prefixed to this string.
	 *
	 * @link https://datatables.net/reference/option/language.aria.sortDescending
	 * @param string $ariaSortDescending
	 * @return $this
	 */
	public function setLanguageAriaSortDescending(string $ariaSortDescending) {
		$this->_setConfig('language.aria.sortDescending', $ariaSortDescending);

		return $this;
	}

	/**
	 * Getter method.
	 * A dot (.) is used to mark the decimal place in Javascript, however, many parts of the world use a comma (,) and
	 * other characters such as the Unicode decimal separator (⎖) or a dash (-) are often used to show the decimal
	 * place in a displayed number.
	 *
	 * When reading such numbers, Javascript won't automatically recognise them as numbers, however, DataTables' type
	 * detection and sorting methods can be instructed through the language.decimal option which character is used as
	 * the decimal place in your numbers. This will be used to correctly adjust DataTables' type detection and sorting
	 * algorithms to sort numbers in your table.
	 *
	 * This option is a little unusual as DataTables will never display a formatted, floating point number (it has no
	 * need to!) so this option only effects how it parses the read data (none of the other language options have this
	 * ability).
	 *
	 * Any character can be set as the decimal place using this option, although the decimal place used in a single
	 * table must be consistent (i.e. numbers with a dot decimal place and comma decimal place cannot both appear in
	 * the same table as the two types are ambiguous). Different tables on the same page can use different decimal
	 * characters if required.
	 *
	 * When given as an empty string (as this parameter is by default) a dot (.) is assumed to be the character used
	 * for the decimal place.
	 *
	 * @link https://datatables.net/reference/option/language.decimal
	 * @return string
	 */
	public function getLanguageDecimal(): ?string {
		return (string)$this->_getConfig('language.decimal');
	}

	/**
	 * Setter method.
	 * A dot (.) is used to mark the decimal place in Javascript, however, many parts of the world use a comma (,) and
	 * other characters such as the Unicode decimal separator (⎖) or a dash (-) are often used to show the decimal
	 * place in a displayed number.
	 *
	 * When reading such numbers, Javascript won't automatically recognise them as numbers, however, DataTables' type
	 * detection and sorting methods can be instructed through the language.decimal option which character is used as
	 * the decimal place in your numbers. This will be used to correctly adjust DataTables' type detection and sorting
	 * algorithms to sort numbers in your table.
	 *
	 * This option is a little unusual as DataTables will never display a formatted, floating point number (it has no
	 * need to!) so this option only effects how it parses the read data (none of the other language options have this
	 * ability).
	 *
	 * Any character can be set as the decimal place using this option, although the decimal place used in a single
	 * table must be consistent (i.e. numbers with a dot decimal place and comma decimal place cannot both appear in
	 * the same table as the two types are ambiguous). Different tables on the same page can use different decimal
	 * characters if required.
	 *
	 * When given as an empty string (as this parameter is by default) a dot (.) is assumed to be the character used
	 * for the decimal place.
	 *
	 * @link https://datatables.net/reference/option/language.decimal
	 * @param string $decimal
	 * @return $this
	 */
	public function setLanguageDecimal(string $decimal) {
		$this->_setConfig('language.decimal', $decimal);

		return $this;
	}

	/**
	 * Getter method.
	 * This string is shown in preference to language.zeroRecords when the table is empty of data (regardless of
	 * filtering) - i.e. there are zero records in the table.
	 *
	 * Note that this is an optional parameter. If it is not given, the value of language.zeroRecords will be used
	 * instead (either the default or given value).
	 *
	 * @link https://datatables.net/reference/option/language.emptyTable
	 * @return string
	 */
	public function getLanguageEmptyTable(): ?string {
		return (string)$this->_getConfig('language.emptyTable');
	}

	/**
	 * Setter method.
	 * This string is shown in preference to language.zeroRecords when the table is empty of data (regardless of
	 * filtering) - i.e. there are zero records in the table.
	 *
	 * Note that this is an optional parameter. If it is not given, the value of language.zeroRecords will be used
	 * instead (either the default or given value).
	 *
	 * @link https://datatables.net/reference/option/language.emptyTable
	 * @param string $emptyTable
	 * @return $this
	 */
	public function setLanguageEmptyTable(string $emptyTable) {
		$this->_setConfig('language.emptyTable', $emptyTable);

		return $this;
	}

	/**
	 * Getter method.
	 * This string gives information to the end user about the information that is current on display on the page. The
	 * following tokens can be used in the string and will be dynamically replaced as the table display updates.
	 *
	 * These tokens can be placed anywhere in the string, or removed as needed by the language requires:
	 *  - _START_ - Display index of the first record on the current page
	 *  - _END_ - Display index of the last record on the current page
	 *  - _TOTAL_ - Number of records in the table after filtering
	 *  - _MAX_ - Number of records in the table without filtering
	 *  - _PAGE_ - Current page number
	 *  - _PAGES_ - Total number of pages of data in the table
	 *
	 * @link https://datatables.net/reference/option/language.info
	 * @return string
	 */
	public function getLanguageInfo(): ?string {
		return (string)$this->_getConfig('language.info');
	}

	/**
	 * Setter method.
	 * This string gives information to the end user about the information that is current on display on the page. The
	 * following tokens can be used in the string and will be dynamically replaced as the table display updates.
	 *
	 * These tokens can be placed anywhere in the string, or removed as needed by the language requires:
	 *  - _START_ - Display index of the first record on the current page
	 *  - _END_ - Display index of the last record on the current page
	 *  - _TOTAL_ - Number of records in the table after filtering
	 *  - _MAX_ - Number of records in the table without filtering
	 *  - _PAGE_ - Current page number
	 *  - _PAGES_ - Total number of pages of data in the table
	 *
	 * @link https://datatables.net/reference/option/language.info
	 * @param string $info
	 * @return $this
	 */
	public function setLanguageInfo(string $info) {
		$this->_setConfig('language.info', $info);

		return $this;
	}

	/**
	 * Getter method.
	 * Display information string for when the table is empty. Typically the format of this string should match info.
	 *
	 * @link https://datatables.net/reference/option/language.infoEmpty
	 * @return string
	 */
	public function getLanguageInfoEmpty(): ?string {
		return (string)$this->_getConfig('language.infoEmpty');
	}

	/**
	 * Setter method.
	 * Display information string for when the table is empty. Typically the format of this string should match info.
	 *
	 * @link https://datatables.net/reference/option/language.infoEmpty
	 * @param string $infoEmpty
	 * @return $this
	 */
	public function setLanguageInfoEmpty(string $infoEmpty) {
		$this->_setConfig('language.infoEmpty', $infoEmpty);

		return $this;
	}

	/**
	 * Getter method.
	 * When a user filters the information in a table, this string is appended to the information (info) to give an
	 * idea of how strong the filtering is.
	 *
	 * The token _MAX_ is dynamically updated - see language.info for information about all available tokens.
	 *
	 * @link https://datatables.net/reference/option/language.infoFiltered
	 * @return string
	 */
	public function getLanguageInfoFiltered(): ?string {
		return (string)$this->_getConfig('language.infoFiltered');
	}

	/**
	 * Setter method.
	 * When a user filters the information in a table, this string is appended to the information (info) to give an
	 * idea of how strong the filtering is.
	 *
	 * The token _MAX_ is dynamically updated - see language.info for information about all available tokens.
	 *
	 * @link https://datatables.net/reference/option/language.infoFiltered
	 * @param string $infoFiltered
	 * @return $this
	 */
	public function setLanguageInfoFiltered(string $infoFiltered) {
		$this->_setConfig('language.infoFiltered', $infoFiltered);

		return $this;
	}

	/**
	 * Getter method.
	 * If can be useful to append extra information to the info string at times, and this variable does exactly that.
	 *
	 * This string will be appended to the language.info (language.infoEmpty and language.infoFiltered in whatever
	 * combination they are being used) at all times.
	 *
	 * @link https://datatables.net/reference/option/language.infoPostFix
	 * @return string
	 */
	public function getLanguageInfoPostFix(): ?string {
		return (string)$this->_getConfig('language.infoPostFix');
	}

	/**
	 * Setter method.
	 * If can be useful to append extra information to the info string at times, and this variable does exactly that.
	 *
	 * This string will be appended to the language.info (language.infoEmpty and language.infoFiltered in whatever
	 * combination they are being used) at all times.
	 *
	 * @link https://datatables.net/reference/option/language.infoPostFix
	 * @param string $infoPostFix
	 * @return $this
	 */
	public function setLanguageInfoPostFix(string $infoPostFix) {
		$this->_setConfig('language.infoPostFix', $infoPostFix);

		return $this;
	}

	/**
	 * Getter method.
	 * Detail the action that will be taken when the drop down menu for the pagination length option is changed. The
	 * token _MENU_ is replaced with a default select list of 10, 25, 50 and 100 (or any other value specified by
	 * lengthMenu), and can be replaced with a custom select list if required.
	 *
	 * @link https://datatables.net/reference/option/language.lengthMenu
	 * @return string
	 */
	public function getLanguageLengthMenu(): ?string {
		return (string)$this->_getConfig('language.lengthMenu');
	}

	/**
	 * Setter method.
	 * Detail the action that will be taken when the drop down menu for the pagination length option is changed. The
	 * token _MENU_ is replaced with a default select list of 10, 25, 50 and 100 (or any other value specified by
	 * lengthMenu), and can be replaced with a custom select list if required.
	 *
	 * @link https://datatables.net/reference/option/language.lengthMenu
	 * @param string $lengthMenu
	 * @return $this
	 */
	public function setLanguageLengthMenu(string $lengthMenu) {
		$this->_setConfig('language.lengthMenu', $lengthMenu);

		return $this;
	}

	/**
	 * Getter method.
	 * When using Ajax sourced data and during the first draw when DataTables is gathering the data, this message is
	 * shown in an empty row in the table to indicate to the end user the the data is being loaded. Note that this
	 * parameter is not used when loading data by server-side processing, just Ajax sourced data with client-side
	 * processing.
	 *
	 * @link https://datatables.net/reference/option/language.loadingRecords
	 * @return string
	 */
	public function getLanguageLoadingRecords(): ?string {
		return (string)$this->_getConfig('language.loadingRecords');
	}

	/**
	 * Setter method.
	 * When using Ajax sourced data and during the first draw when DataTables is gathering the data, this message is
	 * shown in an empty row in the table to indicate to the end user the the data is being loaded. Note that this
	 * parameter is not used when loading data by server-side processing, just Ajax sourced data with client-side
	 * processing.
	 *
	 * @link https://datatables.net/reference/option/language.loadingRecords
	 * @param string $loadingRecords
	 * @return $this
	 */
	public function setLanguageLoadingRecords(string $loadingRecords) {
		$this->_setConfig('language.loadingRecords', $loadingRecords);

		return $this;
	}

	/**
	 * Getter method.
	 * Text used when the pagination control shows the button to take the user to the first page.
	 *
	 * Note that DataTables writes this property to the document as HTML, so you can use HTML tags in the language
	 * string, but HTML entities such as < and > should be encoded as &lt; and &gt; respectively.
	 *
	 * @link https://datatables.net/reference/option/language.paginate.first
	 * @return string
	 */
	public function getLanguagePaginateFirst(): ?string {
		return (string)$this->_getConfig('language.paginate.first');
	}

	/**
	 * Setter method.
	 * Text used when the pagination control shows the button to take the user to the first page.
	 *
	 * Note that DataTables writes this property to the document as HTML, so you can use HTML tags in the language
	 * string, but HTML entities such as < and > should be encoded as &lt; and &gt; respectively.
	 *
	 * @link https://datatables.net/reference/option/language.paginate.first
	 * @param string $paginateFirst
	 * @return $this
	 */
	public function setLanguagePaginateFirst(string $paginateFirst) {
		$this->_setConfig('language.paginate.first', $paginateFirst);

		return $this;
	}

	/**
	 * Getter method.
	 * Text used when the pagination control shows the button to take the user to the last page.
	 *
	 * Note that DataTables writes this property to the document as HTML, so you can use HTML tags in the language
	 * string, but HTML entities such as < and > should be encoded as &lt; and &gt; respectively.
	 *
	 * @link https://datatables.net/reference/option/language.paginate.last
	 * @return string
	 */
	public function getLanguagePaginateLast(): ?string {
		return (string)$this->_getConfig('language.paginate.last');
	}

	/**
	 * Setter method.
	 * Text used when the pagination control shows the button to take the user to the last page.
	 *
	 * Note that DataTables writes this property to the document as HTML, so you can use HTML tags in the language
	 * string, but HTML entities such as < and > should be encoded as &lt; and &gt; respectively.
	 *
	 * @link https://datatables.net/reference/option/language.paginate.last
	 * @param string $paginateLast
	 * @return $this
	 */
	public function setLanguagePaginateLast(string $paginateLast) {
		$this->_setConfig('language.paginate.last', $paginateLast);

		return $this;
	}

	/**
	 * Getter method.
	 * Text to use for the 'next' pagination button (to take the user to the next page).
	 *
	 * Note that DataTables writes this property to the document as HTML, so you can use HTML tags in the language
	 * string, but HTML entities such as < and > should be encoded as &lt; and &gt; respectively.
	 *
	 * @link https://datatables.net/reference/option/language.paginate.next
	 * @return string
	 */
	public function getLanguagePaginateNext(): ?string {
		return (string)$this->_getConfig('language.paginate.next');
	}

	/**
	 * Setter method.
	 * Text to use for the 'next' pagination button (to take the user to the next page).
	 *
	 * Note that DataTables writes this property to the document as HTML, so you can use HTML tags in the language
	 * string, but HTML entities such as < and > should be encoded as &lt; and &gt; respectively.
	 *
	 * @link https://datatables.net/reference/option/language.processing
	 * @param string $paginateNext
	 * @return $this
	 */
	public function setLanguagePaginateNext(string $paginateNext) {
		$this->_setConfig('language.paginate.next', $paginateNext);

		return $this;
	}

	/**
	 * Getter method.
	 * Text that is displayed when the table is processing a user action (usually a sort command or similar).
	 *
	 * @link https://datatables.net/reference/option/language.processing
	 * @return string
	 */
	public function getLanguageProcessing(): ?string {
		return (string)$this->_getConfig('language.processing');
	}

	/**
	 * Setter method.
	 * Text that is displayed when the table is processing a user action (usually a sort command or similar).
	 *
	 * @link https://datatables.net/reference/option/language.processing
	 * @param string $processing
	 * @return $this
	 */
	public function setLanguageProcessing(string $processing) {
		$this->_setConfig('language.processing', $processing);

		return $this;
	}

	/**
	 * Getter method.
	 * Sets the string that is used for DataTables filtering input control.
	 *
	 * The token _INPUT_, if used in the string, is replaced with the HTML text box for the filtering input allowing
	 * control over where it appears in the string. If _INPUT_ is not given then the input box is appended to the
	 * string automatically.
	 *
	 * @link https://datatables.net/reference/option/language.search
	 * @return string
	 */
	public function getLanguageSearch(): ?string {
		return (string)$this->_getConfig('language.search');
	}

	/**
	 * Setter method.
	 * Sets the string that is used for DataTables filtering input control.
	 *
	 * The token _INPUT_, if used in the string, is replaced with the HTML text box for the filtering input allowing
	 * control over where it appears in the string. If _INPUT_ is not given then the input box is appended to the
	 * string automatically.
	 *
	 * @link https://datatables.net/reference/option/language.search
	 * @param string $search
	 * @return $this
	 */
	public function setLanguageSearch(string $search) {
		$this->_setConfig('language.search', $search);

		return $this;
	}

	/**
	 * Getter method.
	 * HTML 5 introduces a placeholder attribute for input type="text" elements to provide informational text for an
	 * input control when it has no value.
	 *
	 * This parameter can be used to set a value for the placeholder attribute in a DataTable's search input.
	 *
	 * @link https://datatables.net/reference/option/language.searchPlaceholder
	 * @return string
	 */
	public function getLanguageSearchPlaceholder(): ?string {
		return (string)$this->_getConfig('language.searchPlaceholder');
	}

	/**
	 * Setter method.
	 * HTML 5 introduces a placeholder attribute for input type="text" elements to provide informational text for an
	 * input control when it has no value.
	 *
	 * This parameter can be used to set a value for the placeholder attribute in a DataTable's search input.
	 *
	 * @link https://datatables.net/reference/option/language.searchPlaceholder
	 * @param string $searchPlaceholder
	 * @return $this
	 */
	public function setLanguageSearchPlaceholder(string $searchPlaceholder) {
		$this->_setConfig('language.searchPlaceholder', $searchPlaceholder);

		return $this;
	}

	/**
	 * Getter method.
	 * DataTables' built in number formatter (formatNumber) is used to format large numbers that are used in the table
	 * information. By default a comma is used, but this can be trivially changed to any other character you wish with
	 * this parameter, suitable for any locality, or set to an empty string if you do not which to have a thousands
	 * separator character.
	 *
	 * Please note that unlike the language.decimal option, the thousands separator option is used for output of
	 * information only (specifically the info option). Changing it does not effect how DataTables reads numeric data.
	 *
	 * @link https://datatables.net/reference/option/language.thousands
	 * @return string
	 */
	public function getLanguageThousands(): ?string {
		return (string)$this->_getConfig('language.thousands');
	}

	/**
	 * Setter method.
	 * DataTables' built in number formatter (formatNumber) is used to format large numbers that are used in the table
	 * information. By default a comma is used, but this can be trivially changed to any other character you wish with
	 * this parameter, suitable for any locality, or set to an empty string if you do not which to have a thousands
	 * separator character.
	 *
	 * Please note that unlike the language.decimal option, the thousands separator option is used for output of
	 * information only (specifically the info option). Changing it does not effect how DataTables reads numeric data.
	 *
	 * @link https://datatables.net/reference/option/language.thousands
	 * @param string $thousands
	 * @return $this
	 */
	public function setLanguageThousands(string $thousands) {
		$this->_setConfig('language.thousands', $thousands);

		return $this;
	}

	/**
	 * Getter method.
	 * All of the language options DataTables provides can be stored in a file on the server, which DataTables will
	 * look up if this parameter is passed. The file must be a valid JSON file, and the object it contains has the same
	 * properties as the language object in the initialiser object.
	 *
	 * There are a wide range of translations readily available on this site, in the internationalisation plug-ins.
	 *
	 * Note that when this parameter is set, DataTables' initialisation will be asynchronous due to the Ajax data load.
	 * That is to say that the table will not be drawn until the Ajax request as completed. As such, any actions that
	 * require the table to have completed its initialisation should be placed into the initComplete callback.
	 *
	 * @link https://datatables.net/reference/option/language.url
	 * @return string
	 */
	public function getLanguageUrl(): ?string {
		return (string)$this->_getConfig('language.url');
	}

	/**
	 * Setter method.
	 * All of the language options DataTables provides can be stored in a file on the server, which DataTables will
	 * look up if this parameter is passed. The file must be a valid JSON file, and the object it contains has the same
	 * properties as the language object in the initialiser object.
	 *
	 * There are a wide range of translations readily available on this site, in the internationalisation plug-ins.
	 *
	 * Note that when this parameter is set, DataTables' initialisation will be asynchronous due to the Ajax data load.
	 * That is to say that the table will not be drawn until the Ajax request as completed. As such, any actions that
	 * require the table to have completed its initialisation should be placed into the initComplete callback.
	 *
	 * @link https://datatables.net/reference/option/language.url
	 * @param string|array|int $url
	 * @return $this
	 */
	public function setLanguageUrl($url) {
		if (!in_array(getType($url), ['string', 'array']) && $url !== MainOption::I18N_TRANSLATION) {
			throw new InvalidArgumentException('Url must be a string or a array with params.');
		} elseif (is_array($url)) {
			$url = Router::url($url);
		} elseif ($url === MainOption::I18N_TRANSLATION) {
			$url = Router::url([
				'controller' => 'Provider',
				'action' => 'getI18nTranslation',
				'plugin' => 'DataTables',
				'prefix' => false,
			]);
		}
		$this->_setConfig('language.url', $url);

		return $this;
	}

	/**
	 * Getter method.
	 * Text shown inside the table records when the is no information to be displayed after filtering.
	 *
	 * Note that language.emptyTable is shown when there is simply no information in the table at all (regardless of
	 * filtering), while this parameter is used for when the table is empty due to filtering.
	 *
	 * @link https://datatables.net/reference/option/language.zeroRecords
	 * @return string
	 */
	public function getLanguageZeroRecords(): ?string {
		return (string)$this->_getConfig('language.zeroRecords');
	}

	/**
	 * Setter method.
	 * Text shown inside the table records when the is no information to be displayed after filtering.
	 *
	 * Note that language.emptyTable is shown when there is simply no information in the table at all (regardless of
	 * filtering), while this parameter is used for when the table is empty due to filtering.
	 *
	 * @link https://datatables.net/reference/option/language.zeroRecords
	 * @param string $zeroRecords
	 * @return $this
	 */
	public function setLanguageZeroRecords(string $zeroRecords) {
		$this->_setConfig('language.zeroRecords', $zeroRecords);

		return $this;
	}

}
