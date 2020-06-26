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
use DataTables\Tools\Functions;

/**
 * Class FunctionsTest
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class FunctionsTest extends TestCase {

	/**
	 * @return void
	 */
	public function testArrayKeyFirst() {
		$result = Functions::getInstance()->arrayKeyFirst(['abc' => 'a', 'as', 'ass']);
		$this->assertEquals('abc', $result);
	}

	/**
	 * @return void
	 */
	public function testArrayKeyLast() {
		$result = Functions::getInstance()->arrayKeyLast(['abc' => 'a', 'as', 'z' => 'ass']);
		$this->assertEquals('z', $result);
	}

	/**
	 * @return void
	 */
	public function testIncreaseTabOnString() {
		$string = "abc\nabc\nabc";
		$this->assertEquals(11, strlen($string));
		$string = Functions::getInstance()->increaseTabOnString($string);
		$this->assertEquals(23, strlen($string));
		$string = "abc\nabc\nabc";
		$this->assertEquals(11, strlen($string));
		$string = Functions::getInstance()->increaseTabOnString($string, 2, true);
		$this->assertEquals(27, strlen($string));
	}

	/**
	 * @return void
	 */
	public function testCheckRegexFormat() {
		$this->assertTrue(Functions::getInstance()->checkRegexFormat('^a'));
		$this->assertFalse(Functions::getInstance()->checkRegexFormat('[121!#@'));
	}

}
