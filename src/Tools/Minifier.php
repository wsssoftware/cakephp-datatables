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

namespace DataTables\Tools;

use MatthiasMullie\Minify\JS as JsMinify;

/**
 * Class Js
 *
 * Created by allancarvalho in abril 17, 2020
 */
class Minifier {

	/**
	 * Minify a js script.
	 *
	 * @param string $content Js to be minified.
	 * @return string Minified Js.
	 */
	public static function js(string $content): string {
		$minifyJs = new JsMinify();

		return $minifyJs->add($content)->minify();
	}

}
