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

namespace DataTables\Table\Option\CallBack;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use DataTables\Tools\Validator;
use InvalidArgumentException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class MainCallBack
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
final class MainCallBack {

	/**
	 * @var string
	 */
	protected $_callbackNamePrefix = 'callback_';

	/**
	 * @var string
	 */
	protected $_callbackName;

	/**
	 * @var string
	 */
	protected $_appTemplateFolder;

	/**
	 * @var string
	 */
	protected $_pluginTemplateFolder;

	/**
	 * @var string
	 */
	protected $_ext = '.twig';

	/**
	 * @var \Twig\Environment
	 */
	protected $_twig;

	/**
	 * @var \Twig\Loader\FilesystemLoader
	 */
	protected $_twigLoader;

	/**
	 * Storage a instance of object.
	 *
	 * @var self[]
	 */
	public static $instance;

	/**
	 * MainCallBack constructor.
	 *
	 * @param string $callbackName
	 * @param string $tablesName
	 * @param string $config
	 */
	public function __construct(string $callbackName, string $tablesName, string $config) {
		$basePath = Configure::read('DataTables.resources.templates');
		if (substr($basePath, -1, 1) !== DS) {
			$basePath .= DS;
		}
		$this->_callbackName = $this->_callbackNamePrefix . $callbackName . $this->_ext;
		$this->_appTemplateFolder = $basePath . $tablesName . DS . $config . DS;
		$this->_pluginTemplateFolder = DATA_TABLES_TEMPLATES . 'twig' . DS . 'js' . DS . 'functions' . DS;
		$this->_twigLoader = new FilesystemLoader();
		$this->_twig = new Environment($this->_twigLoader);
		if (Configure::read('debug') === true) {
			$this->_twig->setCache(false);
		} else {
			$this->_twig->setCache(Configure::read('DataTables.resources.twigCacheFolder'));
		}
	}

	/**
	 * Return a instance of builder object.
	 *
	 * @param string $callBack
	 * @param string $tablesName
	 * @param string $config
	 * @return \DataTables\Table\Option\CallBack\MainCallBack
	 */
	public static function getInstance(string $callBack, string $tablesName, string $config): MainCallBack {
		$callBack = Inflector::underscore($callBack);
		$tablesName = Inflector::camelize($tablesName);
		$config = Inflector::underscore($config);
		$md5 = md5($callBack . $tablesName . $config);
		if (empty(static::$instance[$md5])) {
			static::$instance[$md5] = new self($callBack, $tablesName, $config);
		}
		return static::$instance[$md5];
	}

	/**
	 * Destroy all instances if exist.
	 *
	 * @return void
	 */
	public static function destroyAllInstances(): void {
		static::$instance = [];
	}

	/**
	 * Render callback js functions with application template file or body.
	 *
	 * @param string|array $bodyOrParams To use application template file, leave blank or pass an array with params
	 *                                   that will be used in file. To use the body mode, pass an string that will
	 *                                   putted inside the js function.
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @link https://twig.symfony.com/doc/3.x/api.html
	 */
	public function render($bodyOrParams = []) {
		$bodyParamsType = getType($bodyOrParams);
		if ($bodyParamsType === 'array') {
			$this->checkIfFileExistsOfFail($this->_appTemplateFolder . $this->_callbackName);
			Validator::getInstance()->checkKeysValueTypesOrFail($bodyOrParams, 'string', '*');
			$this->_twigLoader->setPaths($this->_appTemplateFolder);
			$body = $this->_twig->render($this->_callbackName, $bodyOrParams);
		} elseif ($bodyParamsType === 'string') {
			$body = $bodyOrParams;
		} else {
			throw new InvalidArgumentException("$bodyOrParams must be 'string' or 'array'. Found: $bodyParamsType.");
		}
		$this->checkIfFileExistsOfFail($this->_pluginTemplateFolder . $this->_callbackName);
		$this->_twigLoader->setPaths($this->_pluginTemplateFolder);
		return $this->_twig->render($this->_callbackName, compact('body'));
	}

	/**
	 * Check if a file exists or fail.
	 *
	 * @param string $file
	 * @return void
	 */
	private function checkIfFileExistsOfFail(string $file): void {
		if (!is_file($file)) {
			throw new FatalErrorException("File '$file' not found.");
		}
	}

}
