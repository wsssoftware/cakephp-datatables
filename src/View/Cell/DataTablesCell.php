<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\View\Cell;

use Cake\View\Cell;
use DataTables\Table\ConfigBundle;

/**
 * Class DataTablesCell
 *
 * Created by allancarvalho in abril 17, 2020
 */
class DataTablesCell extends Cell {

	/**
	 * Method that return the table html structure.
	 *
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @param array $options A table tag options.
	 *
	 * @return void
	 */
	public function table(ConfigBundle $configBundle, array $options = []): void {
		$options['id'] = $configBundle->getUniqueId();
		$tableContent = '<thead><tr>';
		foreach ($configBundle->Columns->getColumns() as $column) {
			$tableContent .= '<th>' . __d('data_tables', 'Loading') . '...</th>';
		}
		$tableContent .= '</tr><thead>';
		$tableContent .= '<tbody><tr><td style="text-align: center" colspan="' . count($configBundle->Columns->getColumns()) . '">';
		$tableContent .= __d('data_tables', 'Loading {0} data', $configBundle->getDataTables()->getAlias()) . '...';
		$tableContent .= '</td></tr></tbody>';
		$this->set(compact('configBundle', 'options', 'tableContent'));
	}

}
