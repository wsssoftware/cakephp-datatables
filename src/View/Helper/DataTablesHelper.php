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
            $this->setConfig('cache', (bool)Configure::read('DataTables.StorageEngine.disableWhenOnDebug', true));
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
        $this->setConfig('cache', true); // TODO remove

        $exploded = explode('::', $table);
        if (count($exploded) !== 2) {
            throw new InvalidArgumentException('Table param must be a concatenation of Tables class and config. Eg.: Foo::method.');
        }
        $tablesClass = $exploded[0];
        $configMethod = $exploded[1];
        $tablesClassWithNameSpace = Configure::read('App.namespace') . '\\DataTables\\Tables\\' . $tablesClass . 'Tables';
        $md5 = Tools::getInstance()->getTablesMd5($tablesClassWithNameSpace);
        $cacheKey = Inflector::underscore(str_replace('::', '_', $table));

        $builtConfig = null;
        if ($this->getConfig('cache')) {
            /** @var BuiltConfig $builtConfig */
            $builtConfig = Tools::getInstance()->getStorageEngine()->read($cacheKey);
        }
        if (empty($builtConfig) && !$builtConfig instanceof BuiltConfig) {
            $builtConfig = Tools::getInstance()->buildBuiltConfig($tablesClassWithNameSpace, $configMethod, $this->getView(), $md5);
        }
        if ($this->getConfig('cache') && !Tools::getInstance()->getStorageEngine()->save($cacheKey, $builtConfig)) {
            throw new FatalErrorException('Unable to save the BuiltConfig cache.');
        }

        return $builtConfig->getTableHtml();
    }

}
