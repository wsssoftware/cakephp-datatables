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

/**
 * Class DataTablesFilesConfig
 * Created by allancarvalho in abril 18, 2020
 */
final class LocalResourceConfig extends ResourcesConfigAbstract {

	/**
	 * @inheritDoc
	 */
	public function getThemeBase(): array {
		return [
			'css' => [40 => 'style/jquery.dataTables.min.css'],
			'js' => [40 => 'jquery.dataTables.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeBootstrap3(): array {
		return [
			'css' => [40 => 'style/dataTables.bootstrap.min.css'],
			'js' => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.bootstrap.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeBootstrap4(): array {
		return [
			'css' => [40 => 'style/dataTables.bootstrap4.min.css'],
			'js' => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.bootstrap4.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeFoundation(): array {
		return [
			'css' => [40 => 'style/dataTables.foundation.min.css'],
			'js' => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.foundation.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeJQueryUI(): array {
		return [
			'css' => [40 => 'style/dataTables.jqueryui.min.css'],
			'js' => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.jqueryui.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getThemeSemanticUI(): array {
		return [
			'css' => [40 => 'style/dataTables.semanticui.min.css'],
			'js' => [40 => 'jquery.dataTables.min.js', 41 => 'dataTables.semanticui.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getBootstrap3Library(): array {
		return [
			'css' => [20 => 'libraries/bootstrap3/bootstrap.min.css'],
			'js' => [20 => 'libraries/bootstrap3/bootstrap.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getBootstrap4Library(): array {
		return [
			'css' => [20 => 'libraries/bootstrap4/bootstrap.min.css'],
			'js' => [20 => 'libraries/bootstrap4/bootstrap.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getFoundationLibrary(): array {
		return [
			'css' => [20 => 'libraries/foundation/foundation.min.css'],
			'js' => [20 => 'libraries/foundation/foundation.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getJQueryUILibrary(): array {
		return [
			'css' => [20 => 'libraries/jquery-ui/jquery-ui.min.css'],
			'js' => [20 => 'libraries/jquery-ui/jquery-ui.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getSemanticUILibrary(): array {
		return [
			'css' => [20 => 'libraries/semantic-ui/semantic.min.css'],
			'js' => [20 => 'libraries/semantic-ui/semantic.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getJQuery1Library(): array {
		return [
			'js' => [10 => 'libraries/jquery3/jquery.min.js', 11 => 'libraries/jquery1/jquery.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getJQuery3Library(): array {
		return [
			'js' => [10 => 'libraries/jquery3/jquery.min.js'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getAutoFillPlugin(): array {
		return [
			'js' => [150 => 'plugins/auto-fill/dataTables.autoFill.min.js'],
			'theme' => [
				'base' => [
					'css' => [150 => 'plugins/auto-fill/autoFill.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [150 => 'plugins/auto-fill/autoFill.bootstrap.min.css'],
					'js' => [151 => 'plugins/auto-fill/autoFill.bootstrap.min.js'],
				],
				'bootstrap4' => [
					'css' => [150 => 'plugins/auto-fill/autoFill.bootstrap4.min.css'],
					'js' => [151 => 'plugins/auto-fill/autoFill.bootstrap4.min.js'],
				],
				'foundation' => [
					'css' => [150 => 'plugins/auto-fill/autoFill.foundation.min.css'],
					'js' => [151 => 'plugins/auto-fill/autoFill.foundation.min.js'],
				],
				'jqueryui' => [
					'css' => [150 => 'plugins/auto-fill/autoFill.jqueryui.min.css'],
					'js' => [151 => 'plugins/auto-fill/autoFill.jqueryui.min.js'],
				],
				'semanticui' => [
					'css' => [150 => 'plugins/auto-fill/autoFill.semanticui.min.css'],
					'js' => [151 => 'plugins/auto-fill/autoFill.semanticui.min.js'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getButtonsPlugin(): array {
		return [
			'js' => [
				30 => 'plugins/buttons/jszip.min.js', 31 => 'plugins/buttons/pdfmake.min.js',
				32 => 'plugins/buttons/vfs_fonts.min.js', 250 => 'plugins/buttons/dataTables.buttons.min.js',
				252 => 'plugins/buttons/buttons.colVis.min.js', 253 => 'plugins/buttons/buttons.flash.min.js',
				254 => 'plugins/buttons/buttons.html5.min.js', 255 => 'plugins/buttons/buttons.print.min.js',
			],
			'theme' => [
				'base' => [
					'css' => [250 => 'plugins/buttons/buttons.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [250 => 'plugins/buttons/buttons.bootstrap.min.css'],
					'js' => [251 => 'plugins/buttons/buttons.bootstrap4.min.js'],
				],
				'bootstrap4' => [
					'css' => [250 => 'plugins/buttons/buttons.bootstrap4.min.css'],
					'js' => [251 => 'plugins/buttons/dataTables.bootstrap4.min.js'],
				],
				'foundation' => [
					'css' => [250 => 'plugins/buttons/buttons.foundation.min.css'],
					'js' => [251 => 'plugins/buttons/dataTables.foundation.min.js'],
				],
				'jqueryui' => [
					'css' => [250 => 'plugins/buttons/buttons.jqueryui.min.css'],
					'js' => [251 => 'plugins/buttons/dataTables.jqueryui.min.js'],
				],
				'semanticui' => [
					'css' => [250 => 'plugins/buttons/buttons.semanticui.min.css'],
					'js' => [251 => 'plugins/buttons/dataTables.semanticui.min.js'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getColReorderPlugin(): array {
		return [
			'js' => [350 => 'plugins/col-reorder/dataTables.colReorder.min.js'],
			'theme' => [
				'base' => [
					'css' => [350 => 'plugins/col-reorder/colReorder.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [350 => 'plugins/col-reorder/colReorder.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [350 => 'plugins/col-reorder/colReorder.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [350 => 'plugins/col-reorder/colReorder.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [350 => 'plugins/col-reorder/colReorder.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [350 => 'plugins/col-reorder/colReorder.semanticui.min.css'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getFixedColumnsPlugin(): array {
		return [
			'js' => [450 => 'plugins/fixed-columns/dataTables.fixedColumns.min.js'],
			'theme' => [
				'base' => [
					'css' => [450 => 'plugins/fixed-columns/fixedColumns.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [450 => 'plugins/fixed-columns/fixedColumns.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [450 => 'plugins/fixed-columns/fixedColumns.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [450 => 'plugins/fixed-columns/fixedColumns.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [450 => 'plugins/fixed-columns/fixedColumns.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [450 => 'plugins/fixed-columns/fixedColumns.semanticui.min.css'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getFixedHeaderPlugin(): array {
		return [
			'js' => [550 => 'plugins/fixed-header/dataTables.fixedHeader.min.js'],
			'theme' => [
				'base' => [
					'css' => [550 => 'plugins/fixed-header/fixedHeader.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [550 => 'plugins/fixed-header/fixedHeader.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [550 => 'plugins/fixed-header/fixedHeader.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [550 => 'plugins/fixed-header/fixedHeader.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [550 => 'plugins/fixed-header/fixedHeader.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [550 => 'plugins/fixed-header/fixedHeader.semanticui.min.css'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getKeyTablePlugin(): array {
		return [
			'js' => [650 => 'plugins/key-table/dataTables.keyTable.min.js'],
			'theme' => [
				'base' => [
					'css' => [650 => 'plugins/key-table/keyTable.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [650 => 'plugins/key-table/keyTable.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [650 => 'plugins/key-table/keyTable.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [650 => 'plugins/key-table/keyTable.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [650 => 'plugins/key-table/keyTable.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [650 => 'plugins/key-table/keyTable.semanticui.min.css'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getResponsivePlugin(): array {
		return [
			'js' => [750 => 'plugins/responsive/dataTables.responsive.min.js'],
			'theme' => [
				'base' => [
					'css' => [750 => 'plugins/responsive/responsive.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [750 => 'plugins/responsive/responsive.bootstrap.min.css'],
					'js' => [751 => 'plugins/responsive/responsive.bootstrap.min.js'],
				],
				'bootstrap4' => [
					'css' => [750 => 'plugins/responsive/responsive.bootstrap4.min.css'],
					'js' => [751 => 'plugins/responsive/responsive.bootstrap4.min.js'],
				],
				'foundation' => [
					'css' => [750 => 'plugins/responsive/responsive.foundation.min.css'],
					'js' => [751 => 'plugins/responsive/responsive.foundation.min.js'],
				],
				'jqueryui' => [
					'css' => [750 => 'plugins/responsive/responsive.jqueryui.min.css'],
					'js' => [751 => 'plugins/responsive/responsive.jqueryui.min.js'],
				],
				'semanticui' => [
					'css' => [750 => 'plugins/responsive/responsive.semanticui.min.css'],
					'js' => [751 => 'plugins/responsive/responsive.semanticui.min.js'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getRowGroupPlugin(): array {
		return [
			'js' => [850 => 'plugins/row-group/dataTables.rowGroup.min.js'],
			'theme' => [
				'base' => [
					'css' => [850 => 'plugins/row-group/rowGroup.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [850 => 'plugins/row-group/rowGroup.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [850 => 'plugins/row-group/rowGroup.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [850 => 'plugins/row-group/rowGroup.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [850 => 'plugins/row-group/rowGroup.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [850 => 'plugins/row-group/rowGroup.semanticui.min.css'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getRowReorderPlugin(): array {
		return [
			'js' => [950 => 'plugins/row-reorder/dataTables.rowReorder.min.js'],
			'theme' => [
				'base' => [
					'css' => [950 => 'plugins/row-reorder/rowReorder.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [950 => 'plugins/row-reorder/rowReorder.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [950 => 'plugins/row-reorder/rowReorder.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [950 => 'plugins/row-reorder/rowReorder.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [950 => 'plugins/row-reorder/rowReorder.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [950 => 'plugins/row-reorder/rowReorder.semanticui.min.css'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getScrollerPlugin(): array {
		return [
			'js' => [1050 => 'plugins/scroller/dataTables.scroller.min.js'],
			'theme' => [
				'base' => [
					'css' => [1050 => 'plugins/scroller/scroller.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [1050 => 'plugins/scroller/scroller.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [1050 => 'plugins/scroller/scroller.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [1050 => 'plugins/scroller/scroller.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [1050 => 'plugins/scroller/scroller.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [1050 => 'plugins/scroller/scroller.semanticui.min.css'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getSearchPanesPlugin(): array {
		return [
			'js' => [1150 => 'plugins/search-panes/dataTables.searchPanes.min.js'],
			'theme' => [
				'base' => [
					'css' => [1150 => 'plugins/search-panes/searchPanes.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [1150 => 'plugins/search-panes/searchPanes.bootstrap.min.css'],
					'js' => [1151 => 'plugins/search-panes/searchPanes.bootstrap.min.js'],
				],
				'bootstrap4' => [
					'css' => [1150 => 'plugins/search-panes/searchPanes.bootstrap4.min.css'],
					'js' => [1151 => 'plugins/search-panes/searchPanes.bootstrap4.min.js'],
				],
				'foundation' => [
					'css' => [1150 => 'plugins/search-panes/searchPanes.foundation.min.css'],
					'js' => [1151 => 'plugins/search-panes/searchPanes.foundation.min.js'],
				],
				'jqueryui' => [
					'css' => [1150 => 'plugins/search-panes/searchPanes.jqueryui.min.css'],
					'js' => [1151 => 'plugins/search-panes/searchPanes.jqueryui.min.js'],
				],
				'semanticui' => [
					'css' => [1150 => 'plugins/search-panes/searchPanes.semanticui.min.css'],
					'js' => [1151 => 'plugins/search-panes/searchPanes.semanticui.min.js'],
				],
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getSelectPlugin(): array {
		return [
			'js' => [1250 => 'plugins/select/dataTables.select.min.js'],
			'theme' => [
				'base' => [
					'css' => [1250 => 'plugins/select/select.dataTables.min.css'],
				],
				'bootstrap3' => [
					'css' => [1250 => 'plugins/select/select.bootstrap.min.css'],
				],
				'bootstrap4' => [
					'css' => [1250 => 'plugins/select/select.bootstrap4.min.css'],
				],
				'foundation' => [
					'css' => [1250 => 'plugins/select/select.foundation.min.css'],
				],
				'jqueryui' => [
					'css' => [1250 => 'plugins/select/select.jqueryui.min.css'],
				],
				'semanticui' => [
					'css' => [1250 => 'plugins/select/select.semanticui.min.css'],
				],
			],
		];
	}

}
