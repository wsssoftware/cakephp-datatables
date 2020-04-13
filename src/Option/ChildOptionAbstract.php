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

abstract class ChildOptionAbstract extends OptionAbstract {

	/**
	 * @var \DataTables\Option\MainOption|null
	 */
	protected $_mainOption = null;

	/**
	 * ChildOptionAbstract constructor.
	 *
	 * @param \DataTables\Option\MainOption $mainOption
	 */
	public function __construct(MainOption $mainOption) {
		parent::__construct();
		$this->_mainOption = $mainOption;
		foreach ($this->_config as $key => $config) {
			$this->_setConfig($key, $config, false);
		}
		foreach ($this->_mustPrint as $key => $mustPrint) {
			$this->getMainOption()->setMustPrint($key, $mustPrint);
		}
	}

	/**
	 * Return the MainOption class.
	 *
	 * @return \DataTables\Option\MainOption;
	 */
	protected function getMainOption(): MainOption {
		return $this->_mainOption;
	}

}
