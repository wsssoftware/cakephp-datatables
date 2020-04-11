<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Option;

use Cake\Utility\Hash;

class SearchOption extends OptionAbstract {

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_config = [
		'caseInsensitive' => true,
		'regex' => false,
		'search' => null,
		'smart' => true,
	];

	/**
	 * SearchOption constructor.
	 *
	 * @param \DataTables\Option\MainOption $mainOption
	 */
	public function __construct(MainOption $mainOption) {
		$this->_mainOption = $mainOption;
		$this->_configNameInParent = 'search';
	}

	/**
	 * Checker method.
	 * Flag to indicate if the filtering should be case insensitive or not.
	 *
	 * @link https://datatables.net/reference/option/search.caseInsensitive
	 * @return bool
	 */
	public function isCaseInsensitive(): bool {
		return Hash::get($this->_config, 'caseInsensitive');
	}

	/**
	 * Setter method.
	 * Flag to indicate if the filtering should be case insensitive or not.
	 *
	 * @param bool $caseInsensitive
	 * @return \DataTables\Option\MainOption
	 * @link https://datatables.net/reference/option/search.caseInsensitive
	 */
	public function setCaseInsensitive(bool $caseInsensitive): MainOption {
		$this->_config = Hash::insert($this->_config, 'caseInsensitive', $caseInsensitive);
		$this->setMustPrint('caseInsensitive');

		return $this->_mainOption;
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
	public function isRegex(): bool {
		return Hash::get($this->_config, 'regex');
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
	 * @param bool $regex
	 * @return \DataTables\Option\MainOption
	 * @link https://datatables.net/reference/option/search.regex
	 */
	public function setRegex(bool $regex): MainOption {
		$this->_config = Hash::insert($this->_config, 'regex', $regex);
		$this->setMustPrint('search.regex');

		return $this->_mainOption;
	}

	/**
	 * Getter method.
	 * Search term that should be applied to the table.
	 *
	 * @link https://datatables.net/reference/option/search.search
	 * @return string
	 */
	public function getSearch(): string {
		return Hash::get($this->_config, 'search');
	}

	/**
	 * Setter method.
	 * Search term that should be applied to the table.
	 *
	 * @param string $search
	 * @return \DataTables\Option\MainOption
	 * @link https://datatables.net/reference/option/search.search
	 */
	public function setSearch(string $search): MainOption {
		$this->_config = Hash::insert($this->_config, 'search', $search);
		$this->setMustPrint('search');

		return $this->_mainOption;
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
		return Hash::get($this->_config, 'smart');
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
	 * @param bool $smart
	 * @return \DataTables\Option\MainOption
	 * @link https://datatables.net/reference/option/search.smart
	 */
	public function setSearchSmart(bool $smart): MainOption {
		$this->_config = Hash::insert($this->_config, 'smart', $smart);
		$this->setMustPrint('smart');

		return $this->_mainOption;
	}

}
