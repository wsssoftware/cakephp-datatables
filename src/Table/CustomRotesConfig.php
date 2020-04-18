<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Table;

/**
 * Class CustomRotesRules
 *
 * Created by allancarvalho in abril 17, 2020
 */
final class CustomRotesConfig {

	/**
	 * A selected Tables class.
	 *
	 * @var \DataTables\Table\Tables
	 */
	private $_tables;

	/**
	 * Columns constructor.
	 *
	 * @param \DataTables\Table\Tables $tables
	 */
	public function __construct(Tables $tables) {
		$this->_tables = $tables;
	}

}