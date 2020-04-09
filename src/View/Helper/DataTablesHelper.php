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

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use DataTables\Tools\Tools;
use DataTables\Table\BuiltConfig;
use InvalidArgumentException;
use ReflectionException;

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
    protected $_defaultConfig = [
        'cache' => true,
        'minify' => true
    ];

    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        if (Configure::read('debug') === true) {
            $this->setConfig('cache', false);
        }
    }

    /**
     * Render the table html structure of a DataTables configure.
     *
     * @param string $table A Tables class plus config method that you want to render concatenated by '::'. Eg.: 'Foo::main'.
     * @return string
     * @throws ReflectionException
     */
    public function renderTable(string $table): string
    {
        $this->setConfig('cache', true);

        $exploded = explode('::', $table);
        if (count($exploded) !== 2) {
            throw new InvalidArgumentException('Table param must be a concatenation of Tables class and config. Eg.: Foo::method.');
        }
        $tablesClass = $exploded[0];
        $tablesClassWithNameSpace = Configure::read('App.namespace') . '\\DataTables\\Tables\\' . $tablesClass . 'Tables';
        $configMethod = $exploded[1];
        $md5 = Tools::getInstance()->getTablesMd5($tablesClassWithNameSpace);
        $cacheKey = Inflector::underscore(str_replace('::', '_', $table));

        /** @var BuiltConfig $builtConfig */
        $builtConfig = null;
        if ($this->getConfig('cache')) {
            $builtConfig = Tools::getInstance()->getStorageEngine()->read($cacheKey);
        }
        if (empty($builtConfig)) {
            $tables = Tools::getInstance()->buildTables($tablesClassWithNameSpace, $configMethod);
            $queryBaseState = Tools::getInstance()->buildQueryBaseState($tables);
            $columns = Tools::getInstance()->buildColumns($tables);
            $jsOptions = Tools::getInstance()->buildJsOptions($tables);
            $tables->{$configMethod . 'Config'}($queryBaseState, $columns, $jsOptions);
            $renderedTable = $this->getView()->cell('DataTables.DataTables::table', [$columns])->render();
            $builtConfig = new BuiltConfig($md5, $renderedTable, $queryBaseState, $columns, $jsOptions);
        }
        if ($this->getConfig('cache') && !Tools::getInstance()->getStorageEngine()->save($cacheKey, $builtConfig)) {
            throw new FatalErrorException('Unable to save the BuiltConfig cache.');
        }

        return $builtConfig->getTableHtml();
    }

}
