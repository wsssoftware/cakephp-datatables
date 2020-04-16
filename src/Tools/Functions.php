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

use ReflectionClass;

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

	/**
	 * Return current package version.
	 *
	 * @return string
	 */
	public function getPluginCurrentVersion(): string {
	    $version = '0';
	    $packages = json_decode(file_get_contents(ROOT . DS . 'vendor' . DS . 'composer' . DS . 'installed.json'));
		foreach ($packages as $package) {
			if ($package->name === 'allanmcarvalho/cakephp-datatables') {
				$version = $package->version;
			}
	    }
		return $version;
	}

	/**
	 * Return the class md5
	 *
	 * @param string $classWithNameSpace Class name with namespace.
	 * @return string Md5 string
	 * @throws \ReflectionException
	 */
	public function getClassMd5(string $classWithNameSpace): string {
		return md5_file((new ReflectionClass($classWithNameSpace))->getFileName());
	}

	/**
	 * @param string $classWithNameSpace
	 * @throws \ReflectionException
	 * @return string
	 */
	public function getClassAndVersionMd5(string $classWithNameSpace): string {
		$classMd5 = $this->getClassMd5($classWithNameSpace);
		$versionMd5 = md5($this->getPluginCurrentVersion());
		return md5($classMd5 . $versionMd5);
	}

}
