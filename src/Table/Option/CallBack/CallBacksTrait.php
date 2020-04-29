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

use DataTables\Tools\Functions;
use DataTables\Tools\Validator;

/**
 * Trait CallBacksTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 */
trait CallBacksTrait {

	/**
	 * This callback is executed when a TR element is created (and all TD child elements have been inserted), or
	 * registered if using a DOM source, allowing manipulation of the TR element.
	 *
	 * This is particularly useful when using deferred rendering (deferRender) or server-side processing (serverSide)
	 * so you can add events, class name information or otherwise format the row when it is created.
	 *
	 * Accessible parameters inside js function:
	 *  - row (node) - TR row element that has just been created.
	 *  - data (array, object) - Raw data source (array or object) for this row.
	 *  - dataIndex (any) - The index of the row in DataTables' internal storage.
	 *  - cells (node[]) - Since 1.10.17: The cells for the column.
	 *
	 * @link https://datatables.net/reference/option/createdRow
	 * @param array $bodyOrParams
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackCreatedRow($bodyOrParams = []): self {
		Validator::getInstance()->validateBodyOrParams($bodyOrParams);
		$result = CallBackFactory::getInstance('createdRow', $this->_dataTableName)->render($bodyOrParams);
		$callBackTag = Functions::getInstance()->getCallBackReplaceTag(__FUNCTION__);
		$this->_callbackReplaces[$callBackTag] = $result;
		$this->_setConfig('createdRow', $callBackTag);
		return $this;
	}

}
