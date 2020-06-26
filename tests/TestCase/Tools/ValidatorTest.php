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

use Cake\Error\FatalErrorException;
use Cake\TestSuite\TestCase;
use DataTables\Tools\Validator;
use InvalidArgumentException;

class ValidatorTest extends TestCase {

	/**
	 * @return void
	 */
	public function testKeysValueTypesOrFailInvalid1() {
		$this->expectException(FatalErrorException::class);
		Validator::getInstance()->checkKeysValueTypesOrFail(['abc'], 1, 'array');
	}

	/**
	 * @return void
	 */
	public function testKeysValueTypesOrFailInvalid2() {
		$this->expectException(FatalErrorException::class);
		Validator::getInstance()->checkKeysValueTypesOrFail(['abc'], 'integer', 1);
	}

	/**
	 * @return void
	 */
	public function testKeysValueTypesOrFailInvalid3() {
		$this->expectException(InvalidArgumentException::class);
		Validator::getInstance()->checkKeysValueTypesOrFail(['abc'], 'string', 'string');
	}

	/**
	 * @return void
	 */
	public function testKeysValueTypesOrFailInvalid4() {
		$this->expectException(InvalidArgumentException::class);
		Validator::getInstance()->checkKeysValueTypesOrFail([[]], 'integer', 'string');
	}

	/**
	 * @return void
	 */
	public function testArraySizeOrFail() {
		$this->expectException(InvalidArgumentException::class);
		Validator::getInstance()->checkArraySizeOrFail(['a', 'b', 'c'], 2);
	}

	/**
	 * @return void
	 */
	public function testArraySizeOrFail1() {
		$this->expectException(InvalidArgumentException::class);
		Validator::getInstance()->checkArraySizeOrFail(['a', 'b', 'c'], 2, 'CustomMessage');
	}

}
