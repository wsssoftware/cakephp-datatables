<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Tools;

/**
 * Class Functions
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class Functions {

	/**
	 * Storage a instance of object.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Tools\Functions
	 */
	public static function getInstance(): Functions {
		if (static::$instance === null) {
			static::$instance = new self();
		}
		return static::$instance;
	}

	/**
	 * Get first key of array.
	 *
	 * @param array $array
	 * @return int|string|null
	 */
	public function arrayKeyFirst(array $array){
		reset($array);
		return key($array);
	}

	/**
	 * Get last key of array.
	 *
	 * @param array $array
	 * @return int|string|null
	 */
	public function arrayKeyLast(array $array){
		end($array);
		return key($array);
	}

}
