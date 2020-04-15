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
use const DATA_TABLES_TEMPLATES;
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
	protected $_callbackName;

	/**
	 * @var string
	 */
	protected $_callbackNameWithConfig;

	/**
	 * @var string
	 */
	protected $_pluginTemplateFolder = DATA_TABLES_TEMPLATES . 'twig' . DS . 'callbacks' . DS . 'functions' . DS;

	/**
	 * @var string
	 */
	protected $_appTemplateFolder;

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
		$basePath = Configure::read('DataTables.resources.callbacksFolder');
		if (substr($basePath, -1, 1) !== DS) {
			$basePath .= DS;
		}
		$this->_appTemplateFolder = $basePath . Inflector::camelize($tablesName) . DS;
		$this->_callbackNameWithConfig = Inflector::underscore($config . '_' . $this->_callbackName) . $this->_ext;
		$fullFilePath = $this->_pluginTemplateFolder . $this->_callbackName . $this->_ext;
		if (!is_file($fullFilePath)) {
			throw new FatalErrorException("File '$fullFilePath' not found");
		}
		$this->_twigLoader = new FilesystemLoader([
			$this->_pluginTemplateFolder,
			$this->_appTemplateFolder,
		]);
		$this->_twig = new Environment($this->_twigLoader, [
			'cache' => Configure::read('DataTables.resources.callbacksCacheFolder'),
		]);
		if (Configure::read('debug') === true) {
			$this->_twig->setCache(false);
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
		return $this->_twig->render($this->_callbackName . $this->_ext, compact('body'));
	}

	/**
	 * @param array $params
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function renderWithFile(array $params = []) {
		Validator::getInstance()->checkKeysValueTypesOrFail($params, 'string', '*');
		if (!is_file($this->_appTemplateFolder . $this->_callbackNameWithConfig)) {
			throw new FatalErrorException("File '" . $this->_appTemplateFolder . $this->_callbackNameWithConfig . "' not found.");
		}
		return $this->renderWithBody($this->_twig->render($this->_callbackNameWithConfig, $params));
	}

}
