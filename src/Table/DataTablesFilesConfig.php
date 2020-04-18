<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table;

/**
 * Class DataTablesFilesConfig
 * Created by allancarvalho in abril 18, 2020
 */
final class DataTablesFilesConfig {

	/**
	 * @var bool
	 */
	private $_autoLoad = true;

	/**
	 * @return bool
	 */
	public function isAutoLoad(): bool {
		return $this->_autoLoad;
	}

	/**
	 * @param bool $autoLoad
	 *
	 * @return void
	 */
	public function setAutoLoad(bool $autoLoad): void {
		$this->_autoLoad = $autoLoad;
	}

}
