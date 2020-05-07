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

interface ResourcesConfigInterface {

	const THEME_NONE = '';
	const THEME_BASE = 'base';
	const THEME_BOOTSTRAP3 = 'bootstrap3';
	const THEME_BOOTSTRAP4 = 'bootstrap4';
	const THEME_FOUNDATION = 'foundation';
	const THEME_JQUERY_UI = 'jqueryui';
	const THEME_SEMANTIC_UI = 'semanticui';

	const VALID_THEMES = [
		self::THEME_BASE,
		self::THEME_BOOTSTRAP3,
		self::THEME_BOOTSTRAP4,
		self::THEME_FOUNDATION,
		self::THEME_JQUERY_UI,
		self::THEME_SEMANTIC_UI,
	];

	const THEME_GET_FUNCTIONS = [
		self::THEME_BASE => 'getThemeBase',
		self::THEME_BOOTSTRAP3 => 'getThemeBootstrap3',
		self::THEME_BOOTSTRAP4 => 'getThemeBootstrap4',
		self::THEME_FOUNDATION => 'getThemeFoundation',
		self::THEME_JQUERY_UI => 'getThemeJQueryUI',
		self::THEME_SEMANTIC_UI => 'getThemeSemanticUI',
	];

	const THEME_GET_LIBRARY_FUNCTIONS = [
		self::THEME_BOOTSTRAP3 => 'getBootstrap3Library',
		self::THEME_BOOTSTRAP4 => 'getBootstrap4Library',
		self::THEME_FOUNDATION => 'getFoundationLibrary',
		self::THEME_JQUERY_UI => 'getJQueryUILibrary',
		self::THEME_SEMANTIC_UI => 'getSemanticUILibrary',
	];

	const JQUERY_NONE = -1;
	const JQUERY_1 = 1;
	const JQUERY_3 = 3;

	const VALID_JQUERY_STATUS = [
		self::JQUERY_NONE,
		self::JQUERY_1,
		self::JQUERY_3,
	];

	/**
	 * Get base DataTables theme css and js.
	 *
	 * @return array
	 */
	public function getThemeBase(): array;

	/**
	 * Get Bootstrap3 DataTables theme css and js.
	 *
	 * @return array
	 */
	public function getThemeBootstrap3(): array;

	/**
	 * Get Bootstrap4 DataTables theme css and js.
	 *
	 * @return array
	 */
	public function getThemeBootstrap4(): array;

	/**
	 * Get Foundation DataTables theme css and js.
	 *
	 * @return array
	 */
	public function getThemeFoundation(): array;

	/**
	 * Get Foundation DataTables theme css and js.
	 *
	 * @return array
	 */
	public function getThemeJQueryUI(): array;

	/**
	 * Get Foundation DataTables theme css and js.
	 *
	 * @return array
	 */
	public function getThemeSemanticUI(): array;

	/**
	 * Get Bootstrap 3 library css and js.
	 *
	 * @return array
	 */
	public function getBootstrap3Library(): array;

	/**
	 * Get Bootstrap 4 library css and js.
	 *
	 * @return array
	 */
	public function getBootstrap4Library(): array;

	/**
	 * Get Foundation library css and js.
	 *
	 * @return array
	 */
	public function getFoundationLibrary(): array;

	/**
	 * Get jQuery UI library css and js.
	 *
	 * @return array
	 */
	public function getJQueryUILibrary(): array;

	/**
	 * Get Semantic UI library css and js.
	 *
	 * @return array
	 */
	public function getSemanticUILibrary(): array;

	/**
	 * Get jQuery 3 library css and js.
	 *
	 * @return array
	 */
	public function getJQuery1Library(): array;

	/**
	 * Get jQuery 3 library css and js.
	 *
	 * @return array
	 */
	public function getJQuery3Library(): array;

	/**
	 * Get Auto Fill Plugin css and js.
	 *
	 * @return array
	 */
	public function getAutoFillPlugin(): array;

	/**
	 * Get Buttons Plugin css and js.
	 *
	 * @return array
	 */
	public function getButtonsPlugin(): array;

	/**
	 * Get Col Reorder Plugin css and js.
	 *
	 * @return array
	 */
	public function getColReorderPlugin(): array;

	/**
	 * Get Fixed Columns Plugin css and js.
	 *
	 * @return array
	 */
	public function getFixedColumnsPlugin(): array;

	/**
	 * Get Fixed Header Plugin css and js.
	 *
	 * @return array
	 */
	public function getFixedHeaderPlugin(): array;

	/**
	 * Get Key Table Plugin css and js.
	 *
	 * @return array
	 */
	public function getKeyTablePlugin(): array;

	/**
	 * Get Responsive Plugin css and js.
	 *
	 * @return array
	 */
	public function getResponsivePlugin(): array;

	/**
	 * Get Row Group Plugin css and js.
	 *
	 * @return array
	 */
	public function getRowGroupPlugin(): array;

	/**
	 * Get Row Reorder Plugin css and js.
	 *
	 * @return array
	 */
	public function getRowReorderPlugin(): array;

	/**
	 * Get Scroller Plugin css and js.
	 *
	 * @return array
	 */
	public function getScrollerPlugin(): array;

	/**
	 * Get Search Panes Plugin css and js.
	 *
	 * @return array
	 */
	public function getSearchPanesPlugin(): array;

	/**
	 * Get Select Plugin css and js.
	 *
	 * @return array
	 */
	public function getSelectPlugin(): array;

}
