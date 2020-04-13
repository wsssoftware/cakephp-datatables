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
use DataTables\Option\Section\FeaturesOption;
use DataTables\Option\Section\OptionsOption;

/**
 * Class Options
 *
 * @property \DataTables\Option\Section\FeaturesOption $Features
 * @property \DataTables\Option\Section\OptionsOption $Options
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
final class MainOption extends OptionAbstract {

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_mustPrint = [];

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_config = [];

	/**
	 * Define if all options will be printed or not.
	 *
	 * @var bool
	 */
	protected $_printAllOptions = false;

	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct();
		$this->Features = new FeaturesOption($this);
		$this->Options = new OptionsOption($this);
	}

	/**
	 * Get if all options will be printed or not.
	 *
	 * @return bool
	 */
	public function isPrintAllOptions(): bool {
		return $this->_printAllOptions;
	}

	/**
	 * Tell if a field or a many fields will be printed or not.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @return string|array|null A value if exists or null.
	 */
	public function getMustPrint(?string $field = null) {
		if (!empty($field)) {
			return Hash::get($this->_mustPrint, $field, null);
		}

		return $this->_mustPrint;
	}

	/**
	 * Set if a field must be printed or not.
	 *
	 * @param string $field The field that will be changed.
	 * @param bool $must True or false to set if it will printed or not.
	 * @return \DataTables\Option\MainOption
	 */
	public function setMustPrint(string $field, bool $must = true): MainOption {
		$this->_mustPrint = Hash::insert($this->_mustPrint, $field, $must);
		return $this;
	}

	/**
	 * Define if all options will be printed or not.
	 *
	 * @param bool $printAllOptions
	 * @return $this
	 */
	public function setPrintAllOptions(bool $printAllOptions): self {
		$this->_printAllOptions = $printAllOptions;

		return $this;
	}

	/**
	 * Get a config.
	 *
	 * @param string|null $field The field that you intent to see or null for all.
	 * @param string|array|null $default A default value for called config.
	 * @return mixed A value if exists or null.
	 */
	public function getConfig(?string $field = null, $default = null) {
		return $this->_getConfig($field, $default);
	}

	/**
	 * Set manually a config.
	 *
	 * @param string $field The field that will be changed.
	 * @param mixed $value A value intended to save at config.
	 * @param bool $mustPrint Set or not the field as 'mustPrint'.
	 * @return $this
	 */
	public function setConfig(string $field, $value, bool $mustPrint = true): self {
		$this->_setConfig($field, $value, $mustPrint);

		return $this;
	}

	/**
	 * Get the config as json.
	 *
	 * @param bool|null $printAllOptions
	 * @return string
	 */
	public function getConfigAsJson(?bool $printAllOptions = null): string {
		$options = 0;
		if (Configure::read('debug') === true) {
			$options = JSON_PRETTY_PRINT;
		}
		return json_encode($this->getConfigAsArray($printAllOptions), $options);
	}

	/**
	 * Get the config as array.
	 *
	 * @param bool|null $printAllOptions
	 * @return array
	 */
	public function getConfigAsArray(?bool $printAllOptions = null): array {
		if ($printAllOptions === true || (empty($printAllOptions) && $this->_printAllOptions === true)) {
			return $this->_config;
		}
		$result = [];
		foreach (Hash::flatten($this->_mustPrint) as $key => $config) {
			$result = Hash::insert($result, $key, Hash::get($this->_config, $key, null));
		}
		return $result;
	}

}
