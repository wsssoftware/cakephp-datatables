<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */

namespace DataTables\Test\TestCase\Tools;

use Cake\TestSuite\TestCase;
use DataTables\Tools\Minifier;

/**
 * Class JsTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class MinifierTest extends TestCase {

	/**
	 * @return void
	 */
	public function testMinify() {
		$js = 'function {
            var abc = 123;
        }';
		$lenBefore = 47;
		$lenAfter = 21;
		$this->assertEquals($lenBefore, strlen($js));
		$this->assertEquals($lenAfter, strlen(Minifier::js($js)));
	}

}
