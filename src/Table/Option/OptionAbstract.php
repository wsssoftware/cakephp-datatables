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

namespace DataTables\Table\Option;

use Cake\Utility\Hash;

/**
 * Class OptionAbstract
 *
 * Created by allancarvalho in abril 17, 2020
 *
 * @method mixed|void setMustPrint(string $field, bool $must = true)
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

	public function __construct() {
	}

	/**
	 * Get a config.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @param string|array|null $default A default value for called config.
	 * @return mixed|void A value if exists or null.
	 */
	protected function _getConfig(?string $field = null, $default = null) {
		if (!empty($field)) {
			return Hash::get($this->_config, $field, $default);
		}

		return $this->_config;
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
		$this->_config = Hash::insert($this->_config, $field, $value);
		if ($mustPrint === true) {
			$this->setMustPrint($field, true);
		}
	}

}
