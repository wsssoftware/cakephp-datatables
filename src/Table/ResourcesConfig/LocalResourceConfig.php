<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */
declare(strict_types = 1);

namespace DataTables\Table\ResourcesConfig;

use Cake\Core\Configure;

/**
 * Class DataTablesFilesConfig
 * Created by allancarvalho in abril 18, 2020
 */
final class LocalResourceConfig extends ResourcesConfigAbstract {

	/**
	 * Storage a instance of object.
	 *
	 * @var self
	 */
	public static $instance;

	/**
	 * Return a instance of builder object.
	 *
	 * @return \DataTables\Table\ResourcesConfig\LocalResourceConfig
	 */
	public static function getInstance(): LocalResourceConfig {
		if (static::$instance === null) {
			static::$instance = new self();
		}
		return static::$instance;
	}
	/**
	 * LocalResourceConfig constructor.
	 */
	public function __construct() {
		parent::__construct();
		Configure::load('DataTables.local_resource', 'default', true);
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeBase(): array {
		return Configure::read('DataTablesLocalResource.theme.base');
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeBootstrap3(): array {
		return Configure::read('DataTablesLocalResource.theme.bootstrap3');
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeBootstrap4(): array {
		return Configure::read('DataTablesLocalResource.theme.bootstrap4');
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeFoundation(): array {
		return Configure::read('DataTablesLocalResource.theme.foundation');
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeJQueryUI(): array {
		return Configure::read('DataTablesLocalResource.theme.jqueryui');
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeSemanticUI(): array {
		return Configure::read('DataTablesLocalResource.theme.semanticui');
	}

	/**
	 * @inheritDoc
	 */
	public function getBootstrap3Library(): array {
		return Configure::read('DataTablesLocalResource.library.bootstrap3');
	}

	/**
	 * @inheritDoc
	 */
	public function getBootstrap4Library(): array {
		return Configure::read('DataTablesLocalResource.library.bootstrap4');
	}

	/**
	 * @inheritDoc
	 */
	public function getFoundationLibrary(): array {
		return Configure::read('DataTablesLocalResource.library.foundation');
	}

	/**
	 * @inheritDoc
	 */
	public function getJQueryUILibrary(): array {
		return Configure::read('DataTablesLocalResource.library.jqueryui');
	}

	/**
	 * @inheritDoc
	 */
	public function getSemanticUILibrary(): array {
		return Configure::read('DataTablesLocalResource.library.semanticui');
	}

	/**
	 * @inheritDoc
	 */
	public function getJQuery1Library(): array {
		return Configure::read('DataTablesLocalResource.library.jquery1');
	}

	/**
	 * @inheritDoc
	 */
	public function getJQuery3Library(): array {
		return Configure::read('DataTablesLocalResource.library.jquery3');
	}

	/**
	 * @inheritDoc
	 */
	public function getAutoFillPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.autoFill');
	}

	/**
	 * @inheritDoc
	 */
	public function getButtonsPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.buttons');
	}

	/**
	 * @inheritDoc
	 */
	public function getColReorderPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.colReorder');
	}

	/**
	 * @inheritDoc
	 */
	public function getFixedColumnsPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.fixedColumns');
	}

	/**
	 * @inheritDoc
	 */
	public function getFixedHeaderPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.fixedHeader');
	}

	/**
	 * @inheritDoc
	 */
	public function getKeyTablePlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.keyTable');
	}

	/**
	 * @inheritDoc
	 */
	public function getResponsivePlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.responsive');
	}

	/**
	 * @inheritDoc
	 */
	public function getRowGroupPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.rowGroup');
	}

	/**
	 * @inheritDoc
	 */
	public function getRowReorderPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.rowReorder');
	}

	/**
	 * @inheritDoc
	 */
	public function getScrollerPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.scroller');
	}

	/**
	 * @inheritDoc
	 */
	public function getSearchPanesPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.searchPanes');
	}

	/**
	 * @inheritDoc
	 */
	public function getSelectPlugin(): array {
		return Configure::read('DataTablesLocalResource.plugin.select');
	}

}
