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

use BadMethodCallException;
use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

abstract class OptionAbstract implements OptionInterface {

	/**
	 * @var \DataTables\Option\MainOption|null
	 */
	protected $_mainOption = null;

	/**
	 * @var string|null
	 */
	protected $_configNameInParent = null;

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
	 * Define if all options will be printed or not.
	 *
	 * @var bool
	 */
	protected $_printAllOptions = false;

	/**
	 * Magic call to a child OptionAbstract class.
	 *
	 * @param mixed $name
	 * @return mixed
	 */
	public function __get($name) {
		$obj = Hash::get($this->_config, Inflector::variable($name), null);
		if (!empty($obj) && $obj instanceof OptionInterface) {
			return $obj;
		}

			throw new BadMethodCallException('You are allowed to call this param');
	}

	/**
	 * @inheritDoc
	 */
	public function isPrintAllOptions(): bool {
		return $this->_printAllOptions;
	}

	/**
	 * @inheritDoc
	 */
	public function setPrintAllOptions(bool $printAllOptions): OptionInterface {
		$this->_printAllOptions = $printAllOptions;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getConfigAsJson(?bool $printAllOptions = null): string {
		$options = 0;
		if (Configure::read('debug') === true) {
			$options = \JSON_PRETTY_PRINT;
		}
		return json_encode($this->getConfigAsArray($printAllOptions), $options);
	}

	/**
	 * @inheritDoc
	 */
	public function getConfigAsArray(?bool $printAllOptions = null): array {
		$result = [];
		if ($printAllOptions === true || ($printAllOptions !== false && $this->_printAllOptions === true)) {
			$result = $this->_config;
		}
		foreach ($this->_mustPrint as $key => $item) {
			$path = $key;
			if (getType($item) === 'boolean' && $item === true) {
				$result[$key] = Hash::get($this->_config, $path);
			}
		}
		foreach ($result as $key => $item) {
			if ($item instanceof OptionInterface) {
				$result[$key] = $item->getConfigAsArray($printAllOptions);
			}
		}
		return $result;
	}

	/**
	 * @inheritDoc
	 */
	public function getMustPrint(?string $field = null) {
		if (!empty($field)) {
			return Hash::get($this->_mustPrint, $field, null);
		}

		return $this->_mustPrint;
	}

	/**
	 * @inheritDoc
	 */
	public function setMustPrint(string $field, bool $must = true): void {
		if ($this->_mainOption !== $this && !empty($this->_configNameInParent)) {
			$this->_mainOption->setMustPrint($this->_configNameInParent);
		}
		$this->_mustPrint = Hash::insert($this->_mustPrint, $field, true);
	}

}
