<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace TestApp\DataTables;

use DataTables\Table\Assets;
use DataTables\Table\Configure;
use DataTables\Table\Option\MainOption;

/**
 * Class AppDataTables
 */
class AppDataTables {

	/**
	 * This will be applied to all DataTables tables.
	 *
	 * @param \DataTables\Table\Option\MainOption $options Options of DataTable library.
	 * @param \DataTables\Table\Assets $assets Options for asset load.
	 * @return void
	 */
	public function mainConfig(MainOption $options, Assets $assets): void {
		// TODO: Configure here the rules that will be applied to all tables.
	}

	/**
	 * This is the plugin configuration that will be applied to all DataTables tables.
	 *
	 * @param \DataTables\Table\Configure $configure Plugin base configurations.
	 * @return void
	 */
	public function configure(Configure $configure): void {
		// TODO: Configure here the plugin configuration that will be applied to all tables.
	}

}
