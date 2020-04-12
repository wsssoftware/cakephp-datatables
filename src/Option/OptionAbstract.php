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

use Cake\Core\Configure;
use Cake\Utility\Hash;
use const JSON_PRETTY_PRINT;

/**
 * Class OptionAbstract
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
abstract class OptionAbstract implements OptionInterface {

	/**
	 * @var \DataTables\Option\MainOption|null
	 */
	protected $_parentOption = null;

	/**
	 * The options that was set and/or must be printed.
	 *
	 * @var array
	 */
	protected $_mustPrint = [];

	/**
	 * The options that was set and/or must be printed to level.
	 *
	 * @var array
	 */
	protected $_levelMustPrint = [];

	/**
	 * DataTables Js configs
	 *
	 * @var array
	 */
	protected $_config = [];

	/**
	 * DataTables Js level configs
	 *
	 * @var array
	 */
	protected $_levelConfig = [];

	/**
	 * Define if all options will be printed or not.
	 *
	 * @var bool
	 */
	protected $_printAllOptions = false;

	/**
	 * @inheritDoc
	 */
	public function __construct(?MainOption $parentOption = null) {
		if (!empty($parentOption)) {
			$this->_parentOption = $parentOption;
		} elseif ($this instanceof MainOption) {
			$this->_parentOption = $this;
		}
		foreach ($this->_levelConfig as $key => $config) {
			$this->getParentOption()->setConfig($key, $config, false);
		}
		foreach ($this->_levelMustPrint as $key => $mustPrint) {
			$this->getParentOption()->setMustPrint($key, $mustPrint);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getParentOption(): ?MainOption {
		if (!empty($this->_parentOption)) {
			return $this->_parentOption;
		}

		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function isPrintAllOptions(): bool {
		if ($this->getParentOption() !== $this) {
			return $this->getParentOption()->isPrintAllOptions();
		}

		return $this->_printAllOptions;
	}

	/**
	 * @inheritDoc
	 */
	public function setPrintAllOptions(bool $printAllOptions): OptionInterface {
		if ($this->getParentOption() !== $this) {
			$this->setPrintAllOptions($printAllOptions);
		} else {
			$this->_printAllOptions = $printAllOptions;
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getConfig(?string $field = null, $default = null) {
		if ($this->getParentOption() === $this) {
			if (!empty($field)) {
				return Hash::get($this->_config, $field, $default);
			}

			return $this->_config;
		}

		return $this->getParentOption()->getConfig($field);
	}

	/**
	 * @inheritDoc
	 */
	public function setConfig(string $field, $value, bool $mustPrint = true): void {
		if ($this->getParentOption() === $this) {
			$this->_config = Hash::insert($this->_config, $field, $value);
			if ($mustPrint === true) {
				$this->setMustPrint($field, true);
			}
		} else {
			$this->getParentOption()->setConfig($field, $value, $mustPrint);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getMustPrint(?string $field = null) {
		if ($this->getParentOption() === $this) {
			if (!empty($field)) {
				return Hash::get($this->_mustPrint, $field, null);
			}

			return $this->_mustPrint;
		}

		return $this->getParentOption()->getMustPrint($field);
	}

	/**
	 * @inheritDoc
	 */
	public function setMustPrint(string $field, bool $must = true): void {
		if ($this->getParentOption() === $this) {
			$this->_mustPrint = Hash::insert($this->_mustPrint, $field, $must);
		} else {
			$this->getParentOption()->setMustPrint($field);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getConfigAsJson(?bool $printAllOptions = null): string {
		$options = 0;
		if (Configure::read('debug') === true) {
			$options = JSON_PRETTY_PRINT;
		}
		return json_encode($this->getConfigAsArray($printAllOptions), $options);
	}

	/**
	 * @inheritDoc
	 */
	public function getConfigAsArray(?bool $printAllOptions = null): array {
		if ($this->getParentOption() === $this) {
			if ($printAllOptions === true || (empty($printAllOptions) && $this->_printAllOptions === true)) {
				return $this->_config;
			}
			$result = [];
			foreach (Hash::flatten($this->_mustPrint) as $key => $config) {
				$result = Hash::insert($result, $key, Hash::get($this->_config, $key, null));
			}
			return $result;
		}

		return $this->getParentOption()->getConfigAsArray($printAllOptions);
	}

}
