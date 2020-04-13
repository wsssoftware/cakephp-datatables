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

namespace DataTables\Option;

use Cake\Utility\Hash;

/**
 * Class OptionAbstract
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
abstract class OptionAbstract {

	/**
	 * The options that was set and/or must be printed.
	 *
	 * @var array
	 */
	protected $_mustPrint = [];

	/**
	 * DataTables Js configs
	 *
	 * @var array
	 */
	protected $_config = [];

	/**
	 * OptionAbstract constructor.
	 */
	public function __construct() {
	}

	/**
	 * Get a config.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @param string|array|null $default A default value for called config.
	 * @return mixed A value if exists or null.
	 */
	protected function _getConfig(?string $field = null, $default = null) {
		if ($this instanceof MainOption) {
			if (!empty($field)) {
				return Hash::get($this->_config, $field, $default);
			}

			return $this->_config;
		}
								if ($this instanceof ChildOptionAbstract) {
			return $this->getMainOption()->getConfig($field, $default);
		}

		return null;
	}

	/**
	 * Set manually a config.
	 *
	 * @param string $field The field that will be changed.
	 * @param mixed $value A value intended to save at config.
	 * @param bool $mustPrint Set or not the field as 'mustPrint'.
	 * @return void
	 */
	protected function _setConfig(string $field, $value, bool $mustPrint = true): void {
		if ($this instanceof MainOption) {
			$this->_config = Hash::insert($this->_config, $field, $value);
			if ($mustPrint === true) {
				$this->setMustPrint($field, true);
			}
		} elseif ($this instanceof ChildOptionAbstract) {
			$this->getMainOption()->setConfig($field, $value, $mustPrint);
		}
	}

}
