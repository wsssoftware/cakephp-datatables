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

namespace DataTables\Table\Option\CallBack;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use DataTables\Tools\Functions;
use DataTables\Tools\Validator;
use InvalidArgumentException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class MainCallBack
 *
 * Created by allancarvalho in abril 17, 2020
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
	 * @param string $dataTablesName
	 */
	public function __construct(string $callbackName, string $dataTablesName) {
		$basePath = Configure::read('DataTables.resources.templates');
		if (substr($basePath, -1, 1) !== DS) {
			$basePath .= DS;
		}
		$this->_callbackName = $this->_callbackNamePrefix . $callbackName . $this->_ext;
		$this->_appTemplateFolder = $basePath . $dataTablesName . DS;
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
	 * @param string $dataTablesName
	 * @return \DataTables\Table\Option\CallBack\MainCallBack
	 */
	public static function getInstance(string $callBack, string $dataTablesName): MainCallBack {
		$callBack = Inflector::underscore($callBack);
		$dataTablesName = Inflector::camelize($dataTablesName);
		$md5 = md5($callBack . $dataTablesName);
		if (empty(static::$instance[$md5])) {
			static::$instance[$md5] = new self($callBack, $dataTablesName);
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
	public function render($bodyOrParams = []): string {
		if (is_array($bodyOrParams)) {
			$this->checkIfFileExistsOfFail($this->_appTemplateFolder . $this->_callbackName);
			Validator::getInstance()->checkKeysValueTypesOrFail($bodyOrParams, 'string', '*');
			$this->_twigLoader->setPaths($this->_appTemplateFolder);
			$body = $this->_twig->render($this->_callbackName, $bodyOrParams);
		} elseif (is_string($bodyOrParams)) {
			$body = $bodyOrParams;
		} else {
			throw new InvalidArgumentException("$bodyOrParams must be 'string' or 'array'. Found: " . getType($bodyOrParams) . '.');
		}
		$this->checkIfFileExistsOfFail($this->_pluginTemplateFolder . $this->_callbackName);
		$this->_twigLoader->setPaths($this->_pluginTemplateFolder);
		$result = $this->_twig->render($this->_callbackName, compact('body'));
		return Functions::getInstance()->increaseTabOnString($result, 1, true);
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
