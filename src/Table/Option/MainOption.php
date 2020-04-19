<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table\Option;

use Cake\Core\Configure;
use Cake\Utility\Hash;
use DataTables\Table\Option\Section\AjaxOption;
use DataTables\Table\Option\Section\ColumnsOption;
use DataTables\Table\Option\Section\FeaturesOption;
use DataTables\Table\Option\Section\OptionsOption;

/**
 * Class MainOption
 * Created by allancarvalho in abril 17, 2020
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
	 * @var \DataTables\Table\Option\Section\AjaxOption
	 */
	public $Ajax;

	/**
	 * @var \DataTables\Table\Option\Section\FeaturesOption
	 */
	public $Features;

	/**
	 * @var \DataTables\Table\Option\Section\OptionsOption
	 */
	public $Options;

	/**
	 * @var \DataTables\Table\Option\Section\ColumnsOption
	 */
	public $Columns;

	/**
	 * MainOption constructor.
	 *
	 * @param string|null $url
	 */
	public function __construct(string $url = null) {
		parent::__construct();
		$this->Ajax = new AjaxOption($this);
		$this->Features = new FeaturesOption($this);
		$this->Options = new OptionsOption($this);
		$this->Columns = new ColumnsOption($this);
		$this->setConfig('ajax.url', $url);
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
	 * @return \DataTables\Table\Option\MainOption
	 */
	public function setMustPrint(string $field, bool $must = true): MainOption {
		$this->_mustPrint = Hash::insert($this->_mustPrint, $field, $must);

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
