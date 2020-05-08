<?php
/**
 * Copyright (c) Allan Carvalho 2020.
 * Under Mit License
 *
 * link:     https://github.com/wsssoftware/cakephp-data-renderer
 * author:   Allan Carvalho <allan.m.carvalho@outlook.com>
 * license:  MIT License https://github.com/wsssoftware/cakephp-datatables/blob/master/LICENSE
 *
 * @var \DataTables\View\DataTablesView $this;
 * @var array $result;
 * @var \Cake\ORM\Entity[] $data;
 * @var \DataTables\Table\ConfigBundle $configBundle;
 */

use Cake\Core\Configure;
use DataTables\Table\Renderer;

$renderer = new Renderer($configBundle);
$dataTables = $configBundle->getDataTables();
$rows = [];

foreach ($data as $entity) {
	$dataTables->rowRenderer($this, $entity, $renderer);
	$rows[] = $renderer->renderRow($entity);
}

$result['data'] = $rows;
$options = 0;
if (Configure::read('debug') === true) {
	$options = JSON_PRETTY_PRINT;
}
 echo json_encode($result, $options);
