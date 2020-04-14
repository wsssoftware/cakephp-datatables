<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\Table;

use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Table\Tables;

/**
 * Class TablesTest
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class TablesTest extends TestCase {

	/**
	 * @return void
	 */
	public function testWrongClassName() {
		$this->expectException(FatalErrorException::class);
		$tables = $this->getMockBuilder(Tables::class)
			->setMockClassName('ArticlesAbc')
			->getMockForAbstractClass();
	}

}
