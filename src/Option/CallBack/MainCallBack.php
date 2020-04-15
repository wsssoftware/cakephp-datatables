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

namespace DataTables\Option\CallBack;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use DataTables\Tools\Validator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class MainCallBack
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
abstract class MainCallBack {

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
	 * MainCallBack constructor.
	 *
	 * @param string $tablesName
	 * @param string $config
	 */
	public function __construct(string $tablesName, string $config) {
		$basePath = Configure::read('DataTables.resources.templates');
		if (substr($basePath, -1, 1) !== DS) {
			$basePath .= DS;
		}
		$this->_callbackName = $this->_callbackNamePrefix . $this->_callbackName . $this->_ext;
		$this->_appTemplateFolder = $basePath . Inflector::camelize($tablesName) . DS . Inflector::underscore($config) . DS;
		$this->_pluginTemplateFolder = DATA_TABLES_TEMPLATES . 'twig' . DS . 'js' . DS . 'functions' . DS;
		$this->_twigLoader = new FilesystemLoader();
		$this->_twig = new Environment($this->_twigLoader);
		if (Configure::read('debug') === true) {
			$this->_twig->setCache(false);
		} else {
		    $this->_twig->setCache(Configure::read('DataTables.resources.callbacksCacheFolder'));
		}
	}

	/**
	 * @param string $body
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function renderWithBody(string $body) {
		$this->checkIfFileExistsOfFail($this->_pluginTemplateFolder . $this->_callbackName);
	    $this->_twigLoader->setPaths($this->_pluginTemplateFolder);
		return $this->_twig->render($this->_callbackName, compact('body'));
	}

	/**
	 * @param array $params
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function renderWithFile(array $params = []) {
		$this->checkIfFileExistsOfFail($this->_appTemplateFolder . $this->_callbackName);
		Validator::getInstance()->checkKeysValueTypesOrFail($params, 'string', '*');
		$this->_twigLoader->setPaths($this->_appTemplateFolder);
		if (!is_file($this->_appTemplateFolder . $this->_callbackName)) {
			throw new FatalErrorException("File '" . $this->_appTemplateFolder . $this->_callbackName . "' not found.");
		}
		return $this->renderWithBody($this->_twig->render($this->_callbackName, $params));
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
