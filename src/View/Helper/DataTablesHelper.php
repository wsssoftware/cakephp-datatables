<?php
/**
 * Copyright (c) Allan Carvalho 2019.
 * Under Mit License
 * php version 7.2
 *
 * @category CakePHP
 * @package  DataRenderer\Core
 * @author   Allan Carvalho <allan.m.carvalho@outlook.com>
 * @license  MIT License https://github.com/allanmcarvalho/cakephp-data-renderer/blob/master/LICENSE
 * @link     https://github.com/allanmcarvalho/cakephp-data-renderer
 */
declare(strict_types=1);

namespace DataTables\View\Helper;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\ORM\Query;
use Cake\View\Helper;
use Cake\View\View;
use DataTables\Plugin;
use DataTables\Table\Tables;

/**
 * DataTables helper
 */
class DataTablesHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];



    public function table(string $tablesClass, string $config): string
    {
        $tables = Tables::getBuilder()->buildTables($tablesClass, $config);
        $query = Tables::getBuilder()->buildQuery($tables);
        $columns = Tables::getBuilder()->buildColumns($tables);
        $jsOptions = Tables::getBuilder()->buildJsOptions($tables);
        $tables->{$config . 'Config'}($query, $columns, $jsOptions);




        return $this->getView()->element('DataTables.table');
    }

}