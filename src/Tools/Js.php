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

namespace DataTables\Tools;

use MatthiasMullie\Minify\JS as JsMinify;

/**
 * Class Js
 *
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-datatables/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-datatables
 */
class Js {

	/**
	 * Minify a js script.
	 *
	 * @param string $content Js to be minified.
	 * @return string Minified Js.
	 */
	public static function minify(string $content): string {
		$minifyJs = new JsMinify();
		return $minifyJs->add($content)->minify();
	}

}
