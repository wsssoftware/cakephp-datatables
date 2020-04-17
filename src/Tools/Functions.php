<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Tools;

use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Class Functions
 *
 * Created by allancarvalho in abril 17, 2020
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
	 * Check if passed url is the same as current url.
	 *
	 * @param array $url
	 * @return bool
	 */
	public function isSameAsCurrentUrl(array $url = []): bool {
	    $currentUrlMd5 = $this->getUrlMd5(
			Router::getRequest()->getParam('controller'),
			Router::getRequest()->getParam('action'),
			Router::getRequest()->getQuery(),
			Router::getRequest()->getParam('prefix'),
			Router::getRequest()->getParam('pass')
		);
	    $controller = Hash::get($url, 'controller', Router::getRequest()->getParam('controller'));
	    $action = Hash::get($url, 'action', Router::getRequest()->getParam('action'));
	    $query = Hash::get($url, '?', Router::getRequest()->getQuery());
		$prefix = Hash::get($url, 'prefix', Router::getRequest()->getParam('prefix'));
	    if (!is_array($query)) {
			throw new InvalidArgumentException('Query param must be an array.');
		}

		$url = Hash::remove($url, 'controller');
		$url = Hash::remove($url, 'action');
		$url = Hash::remove($url, '?');
		$url = Hash::remove($url, 'prefix');
	    $urlMd5 = $this->getUrlMd5($controller, $action, $query, $prefix, $url);

	    return $currentUrlMd5 === $urlMd5;
	}

	/**
	 * Check if passed params are in current url.
	 *
	 * @param array $url
	 * @return bool
	 */
	public function isInCurrentUrl(array $url = []): bool {
	    $currentController = Router::getRequest()->getParam('controller');
	    $currentAction = Router::getRequest()->getParam('action');
	    $currentQuery = Router::getRequest()->getQuery();
	    $currentPrefix = Router::getRequest()->getParam('prefix');
	    $currentPass = Router::getRequest()->getParam('pass');
		$controller = Hash::get($url, 'controller', $currentController);
		$action = Hash::get($url, 'action', $currentAction);
		$query = Hash::get($url, '?', []);
		$prefix = Hash::get($url, 'prefix', $currentPrefix);
		if (!is_array($query)) {
			throw new InvalidArgumentException('Query param must be an array.');
		}
		$url = Hash::remove($url, 'controller');
		$url = Hash::remove($url, 'action');
		$url = Hash::remove($url, '?');
		$url = Hash::remove($url, 'prefix');
		$pass = $url;
		if ($controller !== $currentController || $action !== $currentAction || $prefix !== $currentPrefix) {
			return false;
		}
		foreach ($pass as $key => $passItem) {
			if (empty($currentPass[$key]) || (!empty($currentPass[$key]) && $passItem !== $currentPass[$key])) {
				return false;
			}
		}
		foreach ($query as $key => $queryItem) {
			if (empty($currentQuery[$key]) || (!empty($currentQuery[$key]) && $queryItem !== $currentQuery[$key])) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Convert Url in md5 string
	 *
	 * @param string $controller
	 * @param string $action
	 * @param array $query
	 * @param string|null $prefix
	 * @param array $pass
	 * @return string
	 */
	private function getUrlMd5(string $controller, string $action, array $query = [], ?string $prefix = null, array $pass = []): string {
	    $md5Items = [];
	    $md5Items[] = Inflector::camelize($controller);
	    $md5Items[] = Inflector::camelize($action);
	    $md5Items[] = !empty($prefix) ? Inflector::camelize($prefix) : '_EMPTY_';
		ksort($pass);
		foreach ($pass as $key => $passItem) {
			$md5Items[] = Inflector::camelize("$key=$passItem");
		}
		ksort($query);
		foreach ($query as $key => $queryItem) {
			$md5Items[] = Inflector::camelize("$key=$queryItem");
		}
		return md5(implode('::', $md5Items));
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
