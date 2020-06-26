<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

namespace DataTables\Test\TestCase\View;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use DataTables\View\DataTablesView;

/**
 * Class DataTablesViewTest
 * Created by allancarvalho in abril 27, 2020
 */
class DataTablesViewTest extends TestCase {

	/**
	 * @return void
	 */
	public function testInitialize() {
		$dataTablesView = new DataTablesView();
		$this->assertInstanceOf(View::class, $dataTablesView);
	}

}
