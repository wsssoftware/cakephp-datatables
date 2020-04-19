<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 */

use Cake\Core\Configure;

$options = 0;
if (Configure::read('debug') === true) {
	$options = JSON_PRETTY_PRINT;
}
 echo json_encode($result, $options);
