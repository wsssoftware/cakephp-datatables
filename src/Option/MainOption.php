<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 * php version 7.2
 *
 * link     https://github.com/allanmcarvalho/cakephp-data-renderer
 * author   Allan Carvalho <allan.m.carvalho@outlook.com>
 */
declare(strict_types = 1);

namespace DataTables\Option;

use DataTables\Option\Section\FeaturesOption;
use DataTables\Option\Section\OptionsOption;

/**
 * Class Options
 *
 * @property \DataTables\Option\Section\FeaturesOption $Features
 * @property \DataTables\Option\Section\OptionsOption $Options
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
final class MainOption extends OptionAbstract {

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_mustPrint = [];

	/**
	 * @var array
	 * @inheritDoc
	 */
	protected $_config = [];

	/**
	 * @inheritDoc
	 */
	public function __construct(?MainOption $parentOption = null) {
	    if (!empty($parentOption)) {
			parent::__construct($parentOption);
		} else {
			parent::__construct($this);
		}
		$this->Features = new FeaturesOption($this);
		$this->Options = new OptionsOption($this);
	}

}
