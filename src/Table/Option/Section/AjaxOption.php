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

namespace DataTables\Table\Option\Section;

use Cake\Error\FatalErrorException;
use DataTables\Table\Option\ChildOptionAbstract;
use DataTables\Table\Option\MainOption;
use InvalidArgumentException;

/**
 * Class AjaxOption
 * Created by allancarvalho in abril 17, 2020
 */
final class AjaxOption extends ChildOptionAbstract {

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_mustPrint = [
		'ajax.type' => true,
	];

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_config = [
		'ajax' => [
			'url' => null,
			'type' => 'GET',
		],
	];

	/**
	 * Getter method.
	 * Url from the ajax request that will give data to table.
	 *
	 * @link https://datatables.net/reference/option/ajax
	 * @return string
	 */
	public function getUrl(): ?string {
		return (string)$this->_getConfig('ajax.url');
	}

	/**
	 * Setter method.
	 * The way that the DataTables will do the request. Can be GET or POST.
	 *
	 * @param string $url
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/ajax
	 */
	public function setUrl(string $url): MainOption {
		$trace = debug_backtrace();
		$expectedClass = 'DataTables\View\Helper\DataTablesHelper::renderTable';
		if (!isset($trace[1]) || $trace[1]['class'] . '::' . $trace[1]['function'] !== $expectedClass) {
			throw new FatalErrorException('This method can only called by DataTablesHelper');
		}
		$this->_setConfig('ajax.url', $url);

		return $this->getMainOption();
	}

	/**
	 * Getter method.
	 * The way that the DataTables will do the request. Can be GET or POST.
	 *
	 * @link https://datatables.net/reference/option/ajax
	 * @return string
	 */
	public function getRequestType(): ?string {
		return (string)$this->_getConfig('ajax.type');
	}

	/**
	 * Setter method.
	 * The way that the DataTables will do the request. Can be GET or POST.
	 *
	 * @param string $requestType
	 * @return \DataTables\Table\Option\MainOption
	 * @link https://datatables.net/reference/option/ajax
	 */
	public function setRequestType(string $requestType): MainOption {
		$requestType = mb_strtolower($requestType);
		if (!in_array($requestType, ['GET', 'POST'])) {
			throw new InvalidArgumentException("\$requestType must be GET or POST. Found: $requestType.");
		}
		$this->_setConfig('ajax.type', $requestType);

		return $this->getMainOption();
	}

}
