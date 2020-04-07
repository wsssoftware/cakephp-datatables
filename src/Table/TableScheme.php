<?php
/**
 * Copyright (c) Allan Carvalho 2019.
 * Under Mit License
 * php version 7.2
 *
 * @category CakePHP
 * @package  DataRenderer\Core
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-data-renderer/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-data-renderer
 */

namespace DataTables\Table;

class TableScheme {

	/**
	 * TableConfig name.
	 *
	 * @var string
	 */
	private $_configName = '';

	/**
	 * Get the TableConfig name.
	 *
	 * @return string|null A string containing the TableConfig name.
	 */
	public function getConfigName() {
		return $this->_configName;
	}

	/**
	 * Set the TableConfig name.
	 *
	 * @param string $name The name of TableConfig.
	 * @return \DataTables\Table\TableScheme
	 */
	public function setConfigName(string $name): self {
		$this->_configName = $name;

		return $this;
	}

}
