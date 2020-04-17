<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Table\Option;

/**
 * Class ChildOptionAbstract
 *
 * Created by allancarvalho in abril 17, 2020
 */
abstract class ChildOptionAbstract extends OptionAbstract {

	/**
	 * @var \DataTables\Table\Option\MainOption|null
	 */
	protected $_mainOption = null;

	/**
	 * ChildOptionAbstract constructor.
	 *
	 * @param \DataTables\Table\Option\MainOption $mainOption
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
	 * @return \DataTables\Table\Option\MainOption;
	 */
	protected function getMainOption(): MainOption {
		return $this->_mainOption;
	}

}
