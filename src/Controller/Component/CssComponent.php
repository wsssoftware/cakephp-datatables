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
 * Class CssComponent
 * Created by allancarvalho in june 26, 2020
 */
class CssComponent extends Component {

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
		Assets::THEME_BASE => [40 => 'style/jquery.dataTables.min.css'],
		Assets::THEME_BOOTSTRAP3 => [40 => 'style/dataTables.bootstrap.min.css'],
		Assets::THEME_BOOTSTRAP4 => [40 => 'style/dataTables.bootstrap4.min.css'],
		Assets::THEME_FOUNDATION => [40 => 'style/dataTables.foundation.min.css'],
		Assets::THEME_JQUERYUI => [40 => 'style/dataTables.jqueryui.min.css'],
		Assets::THEME_SEMANTICUI => [40 => 'style/dataTables.semanticui.min.css'],
	];

	/**
	 * @var array
	 */
	protected $_libraries = [
		Assets::THEME_BASE => [],
		Assets::THEME_BOOTSTRAP3 => [20 => 'libraries/bootstrap3/bootstrap.min.css'],
		Assets::THEME_BOOTSTRAP4 => [20 => 'libraries/bootstrap4/bootstrap.min.css'],
		Assets::THEME_FOUNDATION => [20 => 'libraries/foundation/foundation.min.css'],
		Assets::THEME_JQUERYUI => [20 => 'libraries/jquery-ui/jquery-ui.min.css'],
		Assets::THEME_SEMANTICUI => [20 => 'libraries/semantic-ui/semantic.min.css'],
		Assets::LIBRARY_JQUERY1 => [],
		Assets::LIBRARY_JQUERY3 => [],
	];

	/**
	 * @var array
	 */
	protected $_plugins = [
		Assets::PLUGIN_AUTO_FILL => [
			Assets::THEME_BASE => [150 => 'plugins/auto-fill/autoFill.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [150 => 'plugins/auto-fill/autoFill.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [150 => 'plugins/auto-fill/autoFill.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [150 => 'plugins/auto-fill/autoFill.foundation.min.css'],
			Assets::THEME_JQUERYUI => [150 => 'plugins/auto-fill/autoFill.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [150 => 'plugins/auto-fill/autoFill.semanticui.min.css'],
		],
		Assets::PLUGIN_BUTTONS => [
			Assets::THEME_BASE => [250 => 'plugins/buttons/buttons.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [250 => 'plugins/buttons/buttons.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [250 => 'plugins/buttons/buttons.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [250 => 'plugins/buttons/buttons.foundation.min.css'],
			Assets::THEME_JQUERYUI => [250 => 'plugins/buttons/buttons.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [250 => 'plugins/buttons/buttons.semanticui.min.css'],
		],
		Assets::PLUGIN_COL_REORDER => [
			Assets::THEME_BASE => [350 => 'plugins/col-reorder/colReorder.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [350 => 'plugins/col-reorder/colReorder.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [350 => 'plugins/col-reorder/colReorder.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [350 => 'plugins/col-reorder/colReorder.foundation.min.css'],
			Assets::THEME_JQUERYUI => [350 => 'plugins/col-reorder/colReorder.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [350 => 'plugins/col-reorder/colReorder.semanticui.min.css'],
		],
		Assets::PLUGIN_FIXED_COLUMNS => [
			Assets::THEME_BASE => [450 => 'plugins/fixed-columns/fixedColumns.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [450 => 'plugins/fixed-columns/fixedColumns.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [450 => 'plugins/fixed-columns/fixedColumns.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [450 => 'plugins/fixed-columns/fixedColumns.foundation.min.css'],
			Assets::THEME_JQUERYUI => [450 => 'plugins/fixed-columns/fixedColumns.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [450 => 'plugins/fixed-columns/fixedColumns.semanticui.min.css'],
		],
		Assets::PLUGIN_FIXED_HEADER => [
			Assets::THEME_BASE => [550 => 'plugins/fixed-header/fixedHeader.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [550 => 'plugins/fixed-header/fixedHeader.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [550 => 'plugins/fixed-header/fixedHeader.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [550 => 'plugins/fixed-header/fixedHeader.foundation.min.css'],
			Assets::THEME_JQUERYUI => [550 => 'plugins/fixed-header/fixedHeader.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [550 => 'plugins/fixed-header/fixedHeader.semanticui.min.css'],
		],
		Assets::PLUGIN_KEY_TABLE => [
			Assets::THEME_BASE => [650 => 'plugins/key-table/keyTable.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [650 => 'plugins/key-table/keyTable.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [650 => 'plugins/key-table/keyTable.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [650 => 'plugins/key-table/keyTable.foundation.min.css'],
			Assets::THEME_JQUERYUI => [650 => 'plugins/key-table/keyTable.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [650 => 'plugins/key-table/keyTable.semanticui.min.css'],
		],
		Assets::PLUGIN_RESPONSIVE => [
			Assets::THEME_BASE => [750 => 'plugins/responsive/responsive.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [750 => 'plugins/responsive/responsive.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [750 => 'plugins/responsive/responsive.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [750 => 'plugins/responsive/responsive.foundation.min.css'],
			Assets::THEME_JQUERYUI => [750 => 'plugins/responsive/responsive.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [750 => 'plugins/responsive/responsive.semanticui.min.css'],
		],
		Assets::PLUGIN_ROW_GROUP => [
			Assets::THEME_BASE => [850 => 'plugins/row-group/rowGroup.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [850 => 'plugins/row-group/rowGroup.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [850 => 'plugins/row-group/rowGroup.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [850 => 'plugins/row-group/rowGroup.foundation.min.css'],
			Assets::THEME_JQUERYUI => [850 => 'plugins/row-group/rowGroup.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [850 => 'plugins/row-group/rowGroup.semanticui.min.css'],
		],
		Assets::PLUGIN_ROW_REORDER => [
			Assets::THEME_BASE => [950 => 'plugins/row-reorder/rowReorder.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [950 => 'plugins/row-reorder/rowReorder.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [950 => 'plugins/row-reorder/rowReorder.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [950 => 'plugins/row-reorder/rowReorder.foundation.min.css'],
			Assets::THEME_JQUERYUI => [950 => 'plugins/row-reorder/rowReorder.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [950 => 'plugins/row-reorder/rowReorder.semanticui.min.css'],
		],
		Assets::PLUGIN_SCROLLER => [
			Assets::THEME_BASE => [1050 => 'plugins/scroller/scroller.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [1050 => 'plugins/scroller/scroller.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [1050 => 'plugins/scroller/scroller.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [1050 => 'plugins/scroller/scroller.foundation.min.css'],
			Assets::THEME_JQUERYUI => [1050 => 'plugins/scroller/scroller.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [1050 => 'plugins/scroller/scroller.semanticui.min.css'],
		],
		Assets::PLUGIN_SEARCH_PANES => [
			Assets::THEME_BASE => [1150 => 'plugins/search-panes/searchPanes.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [1150 => 'plugins/search-panes/searchPanes.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [1150 => 'plugins/search-panes/searchPanes.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [1150 => 'plugins/search-panes/searchPanes.foundation.min.css'],
			Assets::THEME_JQUERYUI => [1150 => 'plugins/search-panes/searchPanes.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [1150 => 'plugins/search-panes/searchPanes.semanticui.min.css'],
		],
		Assets::PLUGIN_SELECT => [
			Assets::THEME_BASE => [1250 => 'plugins/select/select.dataTables.min.css'],
			Assets::THEME_BOOTSTRAP3 => [1250 => 'plugins/select/select.bootstrap.min.css'],
			Assets::THEME_BOOTSTRAP4 => [1250 => 'plugins/select/select.bootstrap4.min.css'],
			Assets::THEME_FOUNDATION => [1250 => 'plugins/select/select.foundation.min.css'],
			Assets::THEME_JQUERYUI => [1250 => 'plugins/select/select.jqueryui.min.css'],
			Assets::THEME_SEMANTICUI => [1250 => 'plugins/select/select.semanticui.min.css'],
		],
	];

}
