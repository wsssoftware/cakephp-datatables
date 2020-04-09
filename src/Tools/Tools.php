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

namespace DataTables\Tools;

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\View\Cell;
use Cake\View\View;
use DataTables\StorageEngine\StorageEngineInterface;
use DataTables\Table\BuiltConfig;
use DataTables\Table\Columns;
use DataTables\Table\JsOptions;
use DataTables\Table\QueryBaseState;
use DataTables\Table\Tables;
use ReflectionClass;
use ReflectionException;

class Tools
{

    /**
     * Storage a instance of builder object.
     *
     * @var self
     */
    public static $instance;

    /**
     * Return a instance of builder object.
     *
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function buildBuiltConfig(string $tablesClassWithNameSpace, string $configMethod, View $view, string $md5): BuiltConfig
    {
        $tables = Tools::getInstance()->buildTables($tablesClassWithNameSpace, $configMethod);
        $queryBaseState = Tools::getInstance()->buildQueryBaseState($tables);
        $columns = Tools::getInstance()->buildColumns($tables);
        $jsOptions = Tools::getInstance()->buildJsOptions($tables);
        $tables->{$configMethod . 'Config'}($queryBaseState, $columns, $jsOptions);
        $renderedTable = $view->cell('DataTables.DataTables::table', [$columns])->render();
        return new BuiltConfig($md5, $renderedTable, $queryBaseState, $columns, $jsOptions);
    }

    public function buildTables(string $tablesClassWithNameSpace, string $configMethod): Tables
    {
        unset($exploded);
        /** @var Tables $tables */
        $tables = new $tablesClassWithNameSpace();
        if (empty($tables)) {
            throw new FatalErrorException("Tables class '$tablesClassWithNameSpace' not found.");
        }
        if (!method_exists($tables, $configMethod . 'Config')) {
            throw new FatalErrorException("Config method '{$configMethod}Config' don't exist in '$tablesClassWithNameSpace'.");
        }

        return $tables;
    }

    private function buildQueryBaseState(Tables $table)
    {
        return new QueryBaseState();
    }

    private function buildColumns(Tables $table): Columns
    {
        return new Columns();
    }

    private function buildJsOptions(Tables $table): JsOptions
    {
        return new JsOptions();
    }

    /**
     * Get the configured storage engine.
     *
     * @return StorageEngineInterface
     */
    public function getStorageEngine(): StorageEngineInterface
    {
        $class = Configure::read('DataTables.StorageEngine.class');
        /** @var StorageEngineInterface $storage */
        return new $class();
    }

    /**
     * Return the Tables class md5
     *
     * @param string $tablesClassWithNameSpace Tables class name with namespace.
     * @return string Md5 string
     * @throws ReflectionException
     */
    public function getTablesMd5(string $tablesClassWithNameSpace): string
    {
        return md5_file((new ReflectionClass($tablesClassWithNameSpace))->getFileName());
    }

}
