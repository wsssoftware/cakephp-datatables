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

namespace DataTables\Controller\Component;

use Cake\Controller\Component;
use DataTables\Table\Assets;

/**
 * Class JsComponent
 * Created by allancarvalho in june 26, 2020
 */
class JsComponent extends Component {

	use AssetsTrait;

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [];

	/**
	 * @var array
	 */
	protected $_themes = [
		Assets::THEME_BASE => [40 => 'jquery.dataTables.min.js'],
		Assets::THEME_BOOTSTRAP3 => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.bootstrap.min.js'],
		Assets::THEME_BOOTSTRAP4 => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.bootstrap4.min.js'],
		Assets::THEME_FOUNDATION => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.foundation.min.js'],
		Assets::THEME_JQUERYUI => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.jqueryui.min.js'],
		Assets::THEME_SEMANTICUI => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.semanticui.min.js'],
	];

	/**
	 * @var array
	 */
	protected $_libraries = [
		Assets::THEME_BASE => [],
		Assets::THEME_BOOTSTRAP3 => [20 => 'libraries/bootstrap3/bootstrap.min.js'],
		Assets::THEME_BOOTSTRAP4 => [20 => 'libraries/bootstrap4/bootstrap.min.js'],
		Assets::THEME_FOUNDATION => [20 => 'libraries/foundation/foundation.min.js'],
		Assets::THEME_JQUERYUI => [20 => 'libraries/jquery-ui/jquery-ui.min.js'],
		Assets::THEME_SEMANTICUI => [20 => 'libraries/semantic-ui/semantic.min.js'],
		Assets::LIBRARY_JQUERY1 => [10 => 'libraries/jquery3/jquery.min.js', 11 => 'libraries/jquery1/jquery.min.js'],
		Assets::LIBRARY_JQUERY3 => [10 => 'libraries/jquery3/jquery.min.js'],
	];

	/**
	 * @var array
	 */
	protected $_plugins = [
		Assets::PLUGIN_AUTO_FILL => [
			150 => 'plugins/auto-fill/dataTables.autoFill.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [151 => 'plugins/auto-fill/autoFill.bootstrap.min.js'],
			Assets::THEME_BOOTSTRAP4 => [151 => 'plugins/auto-fill/autoFill.bootstrap4.min.js'],
			Assets::THEME_FOUNDATION => [151 => 'plugins/auto-fill/autoFill.foundation.min.js'],
			Assets::THEME_JQUERYUI => [151 => 'plugins/auto-fill/autoFill.jqueryui.min.js'],
			Assets::THEME_SEMANTICUI => [151 => 'plugins/auto-fill/autoFill.semanticui.min.js'],
		],
		Assets::PLUGIN_BUTTONS => [
			30 => 'plugins/buttons/jszip.min.js',
			31 => 'plugins/buttons/pdfmake.min.js',
			32 => 'plugins/buttons/vfs_fonts.min.js',
			250 => 'plugins/buttons/dataTables.buttons.min.js',
			252 => 'plugins/buttons/buttons.colVis.min.js',
			253 => 'plugins/buttons/buttons.flash.min.js',
			254 => 'plugins/buttons/buttons.html5.min.js',
			255 => 'plugins/buttons/buttons.print.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [251 => 'plugins/buttons/buttons.bootstrap4.min.js'],
			Assets::THEME_BOOTSTRAP4 => [251 => 'plugins/buttons/dataTables.bootstrap4.min.js'],
			Assets::THEME_FOUNDATION => [251 => 'plugins/buttons/dataTables.foundation.min.js'],
			Assets::THEME_JQUERYUI => [251 => 'plugins/buttons/dataTables.jqueryui.min.js'],
			Assets::THEME_SEMANTICUI => [251 => 'plugins/buttons/dataTables.semanticui.min.js'],
		],
		Assets::PLUGIN_COL_REORDER => [
			350 => 'plugins/col-reorder/dataTables.colReorder.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
		Assets::PLUGIN_FIXED_COLUMNS => [
			450 => 'plugins/fixed-columns/dataTables.fixedColumns.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
		Assets::PLUGIN_FIXED_HEADER => [
			550 => 'plugins/fixed-header/dataTables.fixedHeader.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
		Assets::PLUGIN_KEY_TABLE => [
			650 => 'plugins/key-table/dataTables.keyTable.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
		Assets::PLUGIN_RESPONSIVE => [
			750 => 'plugins/responsive/dataTables.responsive.min.js',
			Assets::THEME_BASE => [750 => 'plugins/responsive/responsive.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [751 => 'plugins/responsive/responsive.bootstrap.min.js'],
			Assets::THEME_BOOTSTRAP4 => [751 => 'plugins/responsive/responsive.bootstrap4.min.js'],
			Assets::THEME_FOUNDATION => [751 => 'plugins/responsive/responsive.foundation.min.js'],
			Assets::THEME_JQUERYUI => [751 => 'plugins/responsive/responsive.jqueryui.min.js'],
			Assets::THEME_SEMANTICUI => [751 => 'plugins/responsive/responsive.semanticui.min.js'],
		],
		Assets::PLUGIN_ROW_GROUP => [
			850 => 'plugins/row-group/dataTables.rowGroup.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
		Assets::PLUGIN_ROW_REORDER => [
			950 => 'plugins/row-reorder/dataTables.rowReorder.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
		Assets::PLUGIN_SCROLLER => [
			1050 => 'plugins/scroller/dataTables.scroller.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
		Assets::PLUGIN_SEARCH_PANES => [
			1150 => 'plugins/search-panes/dataTables.searchPanes.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [1151 => 'plugins/search-panes/searchPanes.bootstrap.min.js'],
			Assets::THEME_BOOTSTRAP4 => [1151 => 'plugins/search-panes/searchPanes.bootstrap4.min.js'],
			Assets::THEME_FOUNDATION => [1151 => 'plugins/search-panes/searchPanes.foundation.min.js'],
			Assets::THEME_JQUERYUI => [1151 => 'plugins/search-panes/searchPanes.jqueryui.min.js'],
			Assets::THEME_SEMANTICUI => [1151 => 'plugins/search-panes/searchPanes.semanticui.min.js'],
		],
		Assets::PLUGIN_SELECT => [
			1250 => 'plugins/select/dataTables.select.min.js',
			Assets::THEME_BASE => [],
			Assets::THEME_BOOTSTRAP3 => [],
			Assets::THEME_BOOTSTRAP4 => [],
			Assets::THEME_FOUNDATION => [],
			Assets::THEME_JQUERYUI => [],
			Assets::THEME_SEMANTICUI => [],
		],
	];

}
