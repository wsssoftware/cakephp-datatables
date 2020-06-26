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
 * Class ArticlesDataTables
 *
 * @author Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link https://github.com/allanmcarvalho/cakephp-datatables
 */
class ArticlesDataTables extends DataTables {

	/**
	 * @var string
	 */
	protected $_ormTableName = 'Articles';

	/**
	 * @inheritDoc
	 */
	public function config(ConfigBundle $configBundle): void {
		parent::config($configBundle);
		$configBundle->Columns->addDatabaseColumn('Articles.id');
		$configBundle->Columns->addDatabaseColumn('Articles.title');
		$configBundle->Columns->addDatabaseColumn('Articles.message');
		$configBundle->Columns->addDatabaseColumn('Users.name');
		$configBundle->Columns->addDatabaseColumn('Users.id');
		$configBundle->Columns->addDatabaseColumn('Articles.created');
		$configBundle->Columns->addNonDatabaseColumn('action');
	}

	/**
	 * @inheritDoc
	 */
	public function rowRenderer(DataTablesView $appView, EntityInterface $entity, Renderer $renderer) {
		parent::rowRenderer($appView, $entity, $renderer);
		$renderer->add('Users.name', $entity->user->name);
		$renderer->add('Articles.id', $entity->id);
		$renderer->add('Articles.modified', $entity->modified);
	}

}
