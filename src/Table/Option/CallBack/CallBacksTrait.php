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

use Cake\Utility\Inflector;

/**
 * Trait CallBacksTrait
 *
 * @method mixed|void _getConfig(?string $field = null, $default = null)
 * @method void _setConfig(string $field, $value, bool $mustPrint = true)
 */
trait CallBacksTrait {

	/**
	 * @param string $callbackName
	 * @return string
	 */
	private function getCallBackReplaceTag(string $callbackName): string {
		$callbackName = mb_strtoupper(Inflector::underscore($callbackName)) . '_' . time();
		return "##$callbackName##";
	}

	/**
	 * This callback is executed when a TR element is created (and all TD child elements have been inserted), or
	 * registered if using a DOM source, allowing manipulation of the TR element.
	 *
	 * This is particularly useful when using deferred rendering (deferRender) or server-side processing (serverSide)
	 * so you can add events, class name information or otherwise format the row when it is created.
	 *
	 * @link https://datatables.net/reference/option/createdRow
	 * @param array $bodyOrParams
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @return $this
	 */
	public function callbackCreatedRow($bodyOrParams = []): self {
		$result = CallBackFactory::getInstance('createdRow', $this->_dataTableName)->render($bodyOrParams);
		$callBackTag = $this->getCallBackReplaceTag(__FUNCTION__);
		$this->_callbackReplaces[$callBackTag] = $result;
		$this->_setConfig('createdRow', $callBackTag);
		return $this;
	}

}
