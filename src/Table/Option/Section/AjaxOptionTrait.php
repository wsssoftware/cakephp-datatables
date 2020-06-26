<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link: https://github.com/wsssoftware/cakephp-data-renderer
 * author: Allan Carvalho <allan.m.carvalho@outlook.com>
 * license: MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table\Option\Section;

use InvalidArgumentException;

/**
 * Trait AjaxOptionTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 */
trait AjaxOptionTrait {

	/**
	 * Getter method.
	 * Url from the ajax request that will give data to table.
	 *
	 * @link https://datatables.net/reference/option/ajax
	 * @return string
	 */
	public function getAjaxUrl(): ?string {
		return (string)$this->_getConfig('ajax.url');
	}

	/**
	 * Getter method.
	 * The way that the DataTables will do the request. Can be GET or POST.
	 *
	 * @link https://datatables.net/reference/option/ajax
	 * @return string
	 */
	public function getAjaxRequestType(): ?string {
		return (string)$this->_getConfig('ajax.type');
	}

	/**
	 * Setter method.
	 * The way that the DataTables will do the request. Can be GET or POST.
	 *
	 * @link https://datatables.net/reference/option/ajax
	 * @param string $requestType
	 * @return $this
	 */
	public function setAjaxRequestType(string $requestType) {
		$requestType = mb_strtoupper($requestType);
		if (!in_array($requestType, ['GET', 'POST'])) {
			throw new InvalidArgumentException("\$requestType must be GET or POST. Found: $requestType.");
		}
		$this->_setConfig('ajax.type', $requestType);

		return $this;
	}

}
