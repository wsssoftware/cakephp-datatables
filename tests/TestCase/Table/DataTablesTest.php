<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Table;

use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Table\DataTables;

/**
 * Class TablesTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class DataTablesTest extends TestCase {

	/**
	 * @return void
	 */
	public function testWrongClassName() {
		$this->expectException(FatalErrorException::class);
		$this->getMockBuilder(DataTables::class)
			->setMockClassName('ArticlesAbc')
			->getMockForAbstractClass();
	}

}
