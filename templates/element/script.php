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
use DataTables\Tools\Functions;
use DataTables\Tools\Js;

$minify = !(bool)Configure::read('debug');
$body = '';
foreach ($configBundles as $configBundle) {
	$bodyJson = Functions::getInstance()->increaseTabOnString($configBundle->Options->getConfigAsJson(), 3, true);
	$body .= "            $('#{$configBundle->getUniqueId()}') . DataTable($bodyJson);\n";
}
?>

<?php if ($minify === false): ?>
    <script type="text/javascript">
        $(document).ready(function () {
<?= $body ?>
        });
    </script>
<?php else: ?>
    <script type="text/javascript">$(document).ready(function () {<?= Js::minifyFile($body) ?>});</script>
<?php endif; ?>

