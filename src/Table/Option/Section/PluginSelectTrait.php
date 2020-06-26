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

use DataTables\Tools\Validator;
use InvalidArgumentException;

/**
 * Trait PluginSelectTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 */
trait PluginSelectTrait {

	/**
	 * Getter method.
	 * Select can show summary information about the number of cells selected in the table in the table's information
	 * element (info). This can provide quick and useful information to the end user to show the table's current state
	 * - see select.info.
	 *
	 * This language option can be used to provide information to the end user about the number of cells that are
	 * selected.
	 *
	 * Internally the DataTables' i18n() method is used to determine the string value to display, which can provide
	 * complex singular, plural, dual, etc language strings for true multi-language support. Please refer to the object
	 * section below for details.
	 *
	 * @link https://datatables.net/reference/option/language.select.cells
	 * @return string|array
	 */
	public function getPluginSelectLanguageCells() {
		return $this->_getConfig('language.select.cells');
	}

	/**
	 * Setter method.
	 * Select can show summary information about the number of cells selected in the table in the table's information
	 * element (info). This can provide quick and useful information to the end user to show the table's current state
	 * - see select.info.
	 *
	 * This language option can be used to provide information to the end user about the number of cells that are
	 * selected.
	 *
	 * Internally the DataTables' i18n() method is used to determine the string value to display, which can provide
	 * complex singular, plural, dual, etc language strings for true multi-language support. Please refer to the object
	 * section below for details.
	 *
	 * @link https://datatables.net/reference/option/language.select.cells
	 * @param string|array $cells
	 * @return $this
	 */
	public function setPluginSelectLanguageCells($cells) {
		if (!in_array(getType($cells), ['string', 'array'])) {
			throw new InvalidArgumentException('Cells must be a string or a array with plural translations.');
		} elseif (is_array($cells)) {
			$allowedKeys = ['_', '0', '1'];
			foreach ($cells as $index => $cell) {
				if (!in_array($index, $allowedKeys)) {
					throw new InvalidArgumentException(sprintf('Array key must be %s. Found: %s.', Validator::getInstance()->arrayToStringMessage($allowedKeys), $index));
				}
			}
		}
		$this->_setConfig('language.select.cells', $cells);

		return $this;
	}

	/**
	 * Getter method.
	 * Select can show summary information about the number of columns selected in the table in the table's information
	 * element (info). This can provide quick and useful information to the end user to show the table's current state
	 * - see select.info.
	 *
	 * This language option can be used to provide information to the end user about the number of columns that are
	 * selected.
	 *
	 * Internally the DataTables' i18n() method is used to determine the string value to display, which can provide
	 * complex singular, plural, dual, etc language strings for true multi-language support. Please refer to the object
	 * section below for details.
	 *
	 * @link https://datatables.net/reference/option/language.select.columns
	 * @return string|array
	 */
	public function getPluginSelectLanguageColumns() {
		return $this->_getConfig('language.select.columns');
	}

	/**
	 * Setter method.
	 * Select can show summary information about the number of columns selected in the table in the table's information
	 * element (info). This can provide quick and useful information to the end user to show the table's current state
	 * - see select.info.
	 *
	 * This language option can be used to provide information to the end user about the number of columns that are
	 * selected.
	 *
	 * Internally the DataTables' i18n() method is used to determine the string value to display, which can provide
	 * complex singular, plural, dual, etc language strings for true multi-language support. Please refer to the object
	 * section below for details.
	 *
	 * @link https://datatables.net/reference/option/language.select.columns
	 * @param string|array $columns
	 * @return $this
	 */
	public function setPluginSelectLanguageColumns($columns) {
		if (!in_array(getType($columns), ['string', 'array'])) {
			throw new InvalidArgumentException('Columns must be a string or a array with plural translations.');
		} elseif (is_array($columns)) {
			$allowedKeys = ['_', '0', '1'];
			foreach ($columns as $index => $column) {
				if (!in_array($index, $allowedKeys)) {
					throw new InvalidArgumentException(sprintf('Array key must be %s. Found: %s.', Validator::getInstance()->arrayToStringMessage($allowedKeys), $index));
				}
			}
		}
		$this->_setConfig('language.select.columns', $columns);

		return $this;
	}

	/**
	 * Getter method.
	 * Select can show summary information about the number of rows selected in the table in the table's information
	 * element (info). This can provide quick and useful information to the end user to show the table's current state
	 * - see select.info.
	 *
	 * This language option can be used to provide information to the end user about the number of rows that are
	 * selected.
	 *
	 * Internally the DataTables' i18n() method is used to determine the string value to display, which can provide
	 * complex singular, plural, dual, etc language strings for true multi-language support. Please refer to the object
	 * section below for details.
	 *
	 * @link https://datatables.net/reference/option/language.select.rows
	 * @return string|array
	 */
	public function getPluginSelectLanguageRows() {
		return $this->_getConfig('language.select.rows');
	}

	/**
	 * Setter method.
	 * Select can show summary information about the number of rows selected in the table in the table's information
	 * element (info). This can provide quick and useful information to the end user to show the table's current state
	 * - see select.info.
	 *
	 * This language option can be used to provide information to the end user about the number of rows that are
	 * selected.
	 *
	 * Internally the DataTables' i18n() method is used to determine the string value to display, which can provide
	 * complex singular, plural, dual, etc language strings for true multi-language support. Please refer to the object
	 * section below for details.
	 *
	 * @link https://datatables.net/reference/option/language.select.rows
	 * @param string|array $rows
	 * @return $this
	 */
	public function setPluginSelectLanguageRows($rows) {
		if (!in_array(getType($rows), ['string', 'array'])) {
			throw new InvalidArgumentException('Rows must be a string or a array with plural translations.');
		} elseif (is_array($rows)) {
			$allowedKeys = ['_', '0', '1'];
			foreach ($rows as $index => $row) {
				if (!in_array($index, $allowedKeys)) {
					throw new InvalidArgumentException(sprintf('Array key must be %s. Found: %s.', Validator::getInstance()->arrayToStringMessage($allowedKeys), $index));
				}
			}
		}
		$this->_setConfig('language.select.rows', $rows);

		return $this;
	}

	/**
	 * Checker method.
	 * This option can be used to configure the Select extension for DataTables during the initialisation of a
	 * DataTable.
	 *
	 * When Select has been loaded on a page, all DataTables on that page have the ability to have items selected, but
	 * by default this can only be done through the API - i.e. the end user will have no ability to select items in a
	 * table by default. To enable end user selection, this option should be used (the select.style() method can also
	 * be used after initialisation).
	 *
	 * @link https://datatables.net/reference/option/select
	 * @return bool
	 */
	public function isPluginSelectEnabled(): bool {
		if (is_bool($this->_getConfig('select'))) {
			return $this->_getConfig('select');
		}

		return (bool)$this->getMustPrint('select');
	}

	/**
	 * Setter method.
	 * This option can be used to configure the Select extension for DataTables during the initialisation of a
	 * DataTable.
	 *
	 * When Select has been loaded on a page, all DataTables on that page have the ability to have items selected, but
	 * by default this can only be done through the API - i.e. the end user will have no ability to select items in a
	 * table by default. To enable end user selection, this option should be used (the select.style() method can also
	 * be used after initialisation).
	 *
	 * Exactly what selection the user can make, and how, depends upon the options selected.
	 *
	 * @link https://datatables.net/reference/option/select
	 * @param bool $enabled
	 * @return $this
	 */
	public function setPluginSelectEnabled(bool $enabled) {
		if (empty($this->getMustPrint('select'))) {
			$this->_setConfig('select', $enabled);
		}
		if ($enabled === false) {
			$this->_setConfig('select', $enabled);
		}

		return $this;
	}

	/**
	 * Checker method.
	 * This option provides the ability to have a table act like a select list whereby any items that are selected will
	 * be automatically deselected when clicking outside of a DataTable. This can be useful to make a table "feel" more
	 * like a native operating system control, or if you have multiple tables on a page where only one should have
	 * selection at a time.
	 *
	 * @link https://datatables.net/reference/option/select.blurable
	 * @return bool
	 */
	public function isPluginSelectBlurable(): bool {
		return (bool)$this->_getConfig('select.blurable');
	}

	/**
	 * Setter method.
	 * This option provides the ability to have a table act like a select list whereby any items that are selected will
	 * be automatically deselected when clicking outside of a DataTable. This can be useful to make a table "feel" more
	 * like a native operating system control, or if you have multiple tables on a page where only one should have
	 * selection at a time.
	 *
	 * @link https://datatables.net/reference/option/select.blurable
	 * @param bool $blurable
	 * @return $this
	 */
	public function setPluginSelectBlurable(bool $blurable) {
		$this->_setConfig('select.blurable', $blurable);

		return $this;
	}

	/**
	 * Getter method.
	 * When table items are selected, Select will add a class to those items so it can be appropriately highlighted by
	 * CSS to show the end user that selection.
	 *
	 * The Select and DataTables style sheets have appropriate classes to perform this action, however it can often be
	 * useful to be able to specify your own class to perform your own custom highlighting. This option provides that
	 * ability.
	 *
	 * @link https://datatables.net/reference/option/select.className
	 * @return string
	 */
	public function getPluginSelectClassName(): string {
		return $this->_getConfig('select.className');
	}

	/**
	 * Setter method.
	 * When table items are selected, Select will add a class to those items so it can be appropriately highlighted by
	 * CSS to show the end user that selection.
	 *
	 * The Select and DataTables style sheets have appropriate classes to perform this action, however it can often be
	 * useful to be able to specify your own class to perform your own custom highlighting. This option provides that
	 * ability.
	 *
	 * @link https://datatables.net/reference/option/select.className
	 * @param string $className
	 * @return $this
	 */
	public function setPluginSelectClassName(string $className) {
		$this->_setConfig('select.className', $className);

		return $this;
	}

	/**
	 * Checker method.
	 * Select has the ability to show the end user summary information about the items they have selected in a table -
	 * the number of rows for example. This option can be used to enable / disable that action.
	 *
	 * When enabled and information is shown the following markup is added to the table's information element:
	 *     <span class="select-info"
	 *         <span class="select-item"/>{rows}</span
	 *         <span class="select-item"/>{columns}</span
	 *         <span class="select-item"/>{cells}</span
	 *     </span>
	 *
	 * where {rows}, {columns} and {cells} represents the information to be shown for each item. If there is no
	 * information to be shown the element is not included. If there is no information for any of the items, the
	 * wrapper element (select-info) is not added to the document.
	 *
	 * @link https://datatables.net/reference/option/select.info
	 * @return bool
	 */
	public function isPluginSelectInfo(): bool {
		return $this->_getConfig('select.info');
	}

	/**
	 * Setter method.
	 * Select has the ability to show the end user summary information about the items they have selected in a table -
	 * the number of rows for example. This option can be used to enable / disable that action.
	 *
	 * When enabled and information is shown the following markup is added to the table's information element:
	 *     <span class="select-info"
	 *         <span class="select-item"/>{rows}</span
	 *         <span class="select-item"/>{columns}</span
	 *         <span class="select-item"/>{cells}</span
	 *     </span>
	 *
	 * where {rows}, {columns} and {cells} represents the information to be shown for each item. If there is no
	 * information to be shown the element is not included. If there is no information for any of the items, the
	 * wrapper element (select-info) is not added to the document.
	 *
	 * @link https://datatables.net/reference/option/select.info
	 * @param bool $info
	 * @return $this
	 */
	public function setPluginSelectInfo(bool $info) {
		$this->_setConfig('select.info', $info);

		return $this;
	}

	/**
	 * Getter method.
	 * Select has the ability to select rows, columns or cells in a DataTable. As well as being able to select each
	 * table element type you can also combine the selection to have multiple different item types selected at the
	 * same time.
	 *
	 * This option provides the ability to define which table item type will be selected by user interaction with a
	 * mouse. The items to be selected can also be defined at run time using the select.items() method.
	 *
	 * @link https://datatables.net/reference/option/select.items
	 * @return string
	 */
	public function getPluginSelectItems(): string {
		return $this->_getConfig('select.items');
	}

	/**
	 * Setter method.
	 * Select has the ability to select rows, columns or cells in a DataTable. As well as being able to select each
	 * table element type you can also combine the selection to have multiple different item types selected at the
	 * same time.
	 *
	 * This option provides the ability to define which table item type will be selected by user interaction with a
	 * mouse. The items to be selected can also be defined at run time using the select.items() method.
	 *
	 * @link https://datatables.net/reference/option/select.items
	 * @param string $items
	 * @return $this
	 */
	public function setPluginSelectItems(string $items) {
		$allowedOptions = ['row', 'column', 'cell'];
		if (!in_array($items, $allowedOptions)) {
			throw new InvalidArgumentException(sprintf('Items must be %s. Found: %s.', Validator::getInstance()->arrayToStringMessage($allowedOptions), $items));
		}
		$this->_setConfig('select.items', $items);

		return $this;
	}

	/**
	 * Getter method.
	 * By default when item selection is active (select.style set to anything other than api), Select will select items
	 * based on any cell in the table when it is clicked. However, at times it can be useful to limit this selection to
	 * certain cells (based on column for example), which can be done through this option.
	 *
	 * It is a simple jQuery selector string that is used to attach the event listeners that Select adds to the table.
	 *
	 * @link https://datatables.net/reference/option/select.selector
	 * @return string
	 */
	public function getPluginSelectSelector(): string {
		return $this->_getConfig('select.selector');
	}

	/**
	 * Setter method.
	 * By default when item selection is active (select.style set to anything other than api), Select will select items
	 * based on any cell in the table when it is clicked. However, at times it can be useful to limit this selection to
	 * certain cells (based on column for example), which can be done through this option.
	 *
	 * It is a simple jQuery selector string that is used to attach the event listeners that Select adds to the table.
	 *
	 * @link https://datatables.net/reference/option/select.selector
	 * @param string $selector
	 * @return $this
	 */
	public function setPluginSelectSelector(string $selector) {
		$this->_setConfig('select.selector', $selector);

		return $this;
	}

	/**
	 * Getter method.
	 * Select provides a number of different built in ways that an end user can interact with the selection of items in
	 * the table, which is controlled by this parameter (and select.style() after initialisation).
	 *
	 * The default mode of operation is based on the selection of files in modern operating systems where the ctrl/cmd
	 * and shift keys can be used to provide complex operations.
	 *
	 * Note that while the api option disables item selection via Select's built in event handler, it is quite possible
	 * to use the API to still provide the end user with the ability to select / deselect items based on your own event
	 * handlers.
	 *
	 * This option can take one of the following values:
	 *  - api - Selection can only be performed via the AP
	 *  - single - Only a single item can be selected, any other selected items will be automatically deselected when a
	 *    new item is selected
	 *  - multi - Multiple items can be selected. Selection is performed by simply clicking on the items to be selecte
	 *  - os - Operating System (OS) style selection. This is the most comprehensive option and provides complex
	 *    behaviours such as ctrl/cmd clicking to select / deselect individual items, shift clicking to select ranges
	 *    and an unmodified click to select a single item
	 *  - multi+shift - a hybrid between the os style and multi, allowing easy multi-row selection without immediate
	 *    de-selection when clicking on a row.
	 *
	 * @link https://datatables.net/reference/option/select.style
	 * @return string
	 */
	public function getPluginSelectStyle(): string {
		return $this->_getConfig('select.style');
	}

	/**
	 * Setter method.
	 * Select provides a number of different built in ways that an end user can interact with the selection of items in
	 * the table, which is controlled by this parameter (and select.style() after initialisation).
	 *
	 * The default mode of operation is based on the selection of files in modern operating systems where the ctrl/cmd
	 * and shift keys can be used to provide complex operations.
	 *
	 * Note that while the api option disables item selection via Select's built in event handler, it is quite possible
	 * to use the API to still provide the end user with the ability to select / deselect items based on your own event
	 * handlers.
	 *
	 * This option can take one of the following values:
	 *  - api - Selection can only be performed via the AP
	 *  - single - Only a single item can be selected, any other selected items will be automatically deselected when a
	 *    new item is selected
	 *  - multi - Multiple items can be selected. Selection is performed by simply clicking on the items to be selecte
	 *  - os - Operating System (OS) style selection. This is the most comprehensive option and provides complex
	 *    behaviours such as ctrl/cmd clicking to select / deselect individual items, shift clicking to select ranges
	 *    and an unmodified click to select a single item
	 *  - multi+shift - a hybrid between the os style and multi, allowing easy multi-row selection without immediate
	 *    de-selection when clicking on a row.
	 *
	 * @link https://datatables.net/reference/option/select.style
	 * @param string $style
	 * @return $this
	 */
	public function setPluginSelectStyle(string $style) {
		$allowedOptions = ['api', 'single', 'multi', 'os', 'multi+shift'];
		if (!in_array($style, $allowedOptions)) {
			throw new InvalidArgumentException(sprintf('Items must be %s. Found: %s.', Validator::getInstance()->arrayToStringMessage($allowedOptions), $style));
		}
		$this->_setConfig('select.style', $style);

		return $this;
	}

	/**
	 * Checker method.
	 * This option provides the ability to disable the deselection of selected rows when they are clicked. As standard
	 * when a selected row is clicked it will be deselected. When the toggleable option is set to false then it will
	 * disable this feature and selected rows will not deselect when they are clicked.
	 *
	 * @link https://datatables.net/reference/option/select.toggleable
	 * @return bool
	 */
	public function isPluginSelectToggleable(): bool {
		return $this->_getConfig('select.toggleable');
	}

	/**
	 * Setter method.
	 * This option provides the ability to disable the deselection of selected rows when they are clicked. As standard
	 * when a selected row is clicked it will be deselected. When the toggleable option is set to false then it will
	 * disable this feature and selected rows will not deselect when they are clicked.
	 *
	 * @link https://datatables.net/reference/option/select.toggleable
	 * @param bool $toggleable
	 * @return $this
	 */
	public function setPluginSelectToggleable(bool $toggleable) {
		$this->_setConfig('select.toggleable', $toggleable);

		return $this;
	}

}
