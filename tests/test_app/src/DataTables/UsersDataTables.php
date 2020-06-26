<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link https://github.com/allanmcarvalho/cakephp-data-renderer
 * author Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace TestApp\DataTables;

use Cake\Datasource\EntityInterface;
use DataTables\Table\ConfigBundle;
use DataTables\Table\DataTables;
use DataTables\Table\Renderer;
use DataTables\View\DataTablesView;

/**
 * Class UsersDataTables
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class UsersDataTables extends DataTables {

	/**
	 * @var string
	 */
	protected $_ormTableName = 'Users';

	/**
	 * @param \DataTables\Table\ConfigBundle $configBundle
	 * @return void
	 */
	public function config(ConfigBundle $configBundle): void {
		parent::config($configBundle);
		$configBundle->Columns->addDatabaseColumn('Users.id');
		$configBundle->Columns->addDatabaseColumn('Users.name');
		$configBundle->Columns->addDatabaseColumn('Articles.id');
		$configBundle->Columns->addDatabaseColumn('Articles.title');
		$configBundle->Columns->addDatabaseColumn('Users.created');
	}

	/**
	 * @inheritDoc
	 */
	public function rowRenderer(DataTablesView $appView, EntityInterface $entity, Renderer $renderer) {
		parent::rowRenderer($appView, $entity, $renderer);
		$renderer->add('Users.id', $entity->id);
		$renderer->add('Articles.id', count($entity->articles));
	}

}
