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

namespace DataTables\Controller;

use Cake\View\JsonView;
use DataTables\Tools\Builder;

/**
 * Class ProviderController
 * Created by allancarvalho in abril 17, 2020
 */
class ProviderController extends AppController {

	/**
	 * Index method
	 *
	 * @param string $tablesCass
	 * @param string $configMethod
	 * @return \Cake\Http\Response|null|void Renders view
	 * @throws \ReflectionException
	 */
	public function getData(string $tablesCass, string $configMethod) {
		$configMethod = Builder::getInstance()->getConfigBundle("$tablesCass::$configMethod");
		$this->viewBuilder()->setClassName(JsonView::class);
		$this->set(compact('configMethod'));
	}

}
