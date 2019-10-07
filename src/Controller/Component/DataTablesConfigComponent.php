<?php
/**
 * Copyright (c) 2018. Allan Carvalho
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace DataTables\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Error\FatalErrorException;

/**
 * CakePHP DataTableConfigComponent
 * @author allan
 */
class DataTablesConfigComponent extends Component
{

    private $dataTableConfig = [];
    private $currentConfig = null;
    private $defaultOptions = [];

    /**
     * Supported type maps
     *
     * See: https://datatables.net/reference/option/columns.type
     */
    private $typeMap = [
        'date' => 'date',
        'datetime' => 'date',
        'num' => 'num',
        'integer' => 'num',
        'int' => 'num',
        'num-fmt' => 'num-fmt',
        'html-num-fmt' => 'html-num-fmt',
        'html' => 'html',
        'string' => 'string',
        'text' => 'string',
    ];

    private $supportedTraits = [
        'DataTables\Controller\DataTablesAjaxRequestTrait',
        'DataTables\Controller\FocSearchRequestTrait',
    ];

    public function initialize(array $config)
    {
        $this->dataTableConfig = &$config['DataTablesConfig'];
        parent::initialize($config);
    }

    /**
     * Set initial config name
     * @param string $name
     * @param $defaultOptions
     * @return $this
     */
    public function setDataTableConfig($name, $defaultOptions)
    {
        $this->defaultOptions = $defaultOptions;
        $this->currentConfig = $name;
        $this->dataTableConfig[$name]['id'] = 'dt' . $name;
        $this->dataTableConfig[$name]['table'] = $name;
        $this->dataTableConfig[$name]['queryOptions'] = [];
        $this->dataTableConfig[$name]['options'] = $this->defaultOptions;
        $this->dataTableConfig[$name]['finder'] = "all";
        $this->dataTableConfig[$name]['trait'] = "DataTablesAjaxRequestTrait";
        $urls = [];
        /** @var Controller $controller */
        $controller = $this->getController();
        $traits = $this->classUsesDeep($controller);
        if (empty($traits)) {
            throw new FatalErrorException('Cannot find any traits loaded in controller.');
        }
        foreach ($traits as $trait) {
            if (!in_array($trait, $this->supportedTraits)) {
                continue;
            }
            switch ($trait) {
                case 'DataTables\Controller\DataTablesAjaxRequestTrait':
                    $urls['DataTablesAjaxRequestTrait'] = [
                        'controller' => $controller->getName(),
                        'action' => 'getDataTablesContent',
                    ];
                    break;
                case 'DataTables\Controller\FocSearchRequestTrait':
                    $urls['FocSearchRequestTrait'] = [
                        'controller' => $controller->getName(),
                        'action' => 'getFocSearchDataTablesContent',
                    ];
                    break;
            }
        }
        $this->dataTableConfig[$name]['urls'] = $urls;
        return $this;
    }

    /**
     * Set a finder type from method "find()"
     * @param string $finder
     * @return $this
     */
    public function finder($finder = "all")
    {
        $this->dataTableConfig[$this->currentConfig]['finder'] = $finder;

        return $this;
    }

    /**
     * Set a custom table name. Default is config name
     * @param string $name
     * @return $this
     */
    public function table($name)
    {
        $this->dataTableConfig[$this->currentConfig]['table'] = $name;

        return $this;
    }

    /**
     * Set a column at datatable config
     * @param string $name
     * @param array $options
     * @return DataTablesConfigComponent
     */
    public function column($name, array $options = [])
    {
        if (!empty($options['order'])) {
            if (is_array($options['order'])) {
                if (empty($options['order']['index']) and empty($options['order']['dir'])) {
                    unset($options['order']);
                } else if (!empty($options['order']['index']) and empty($options['order']['dir'])) {
                    unset($options['order']);
                } else if (empty($options['order']['index']) and !empty($options['order']['dir'])) {
                    $options['order'] = $options['order']['dir'];
                }
            } else {
                if (!in_array($options['order'], ['asc', 'desc'])) {
                    unset($options['order']);
                }
            }

        }
        $options += [
            'label' => $name,
            'database' => true,
            'searchable' => true,
            'orderable' => true,
            'className' => null,
            'orderDataType' => 'dom-text',
            'type' => 'string',
            'name' => $name,
            'visible' => true,
            'width' => null,
            'defaultContent' => null,
            'contentPadding' => null,
            'cellType' => 'td',
        ];

        if ($options['database'] === false) {
            $options['orderable'] = false;
            $options['searchable'] = false;
        }

        if (!array_key_exists($options['type'], $this->typeMap)) {
            throw new \InvalidArgumentException($options['type'] . ' is not a supported type');
        }
        $options['type'] = $this->typeMap[$options['type']];

        $this->dataTableConfig[$this->currentConfig]['columns'][$name] = $options;
        $this->dataTableConfig[$this->currentConfig]['columnsIndex'][] = $name;
        return $this;
    }

    /**
     * Set a database column to use in data render
     * @param string $name a database table column name
     * @param bool $searchable if true, the search query will find this column too
     * @return $this
     */
    public function databaseColumn($name, $searchable = false)
    {
        $this->dataTableConfig[$this->currentConfig]['databaseColumns'][$name] = [
            'name' => $name,
            'searchable' => (bool)$searchable
        ];

        return $this;
    }

    /**
     * Set DataTables general configs
     * @param array $options
     * @return $this
     */
    public function options(array $options = [])
    {
        $this->dataTableConfig[$this->currentConfig]['options'] = $options;
        $this->dataTableConfig[$this->currentConfig]['options'] += $this->defaultOptions;
        return $this;
    }

    /**
     * Set options for SQL query
     * @param array $options
     * @return $this
     */
    public function queryOptions(array $options = [])
    {
        $this->dataTableConfig[$this->currentConfig]['queryOptions'] = $options;
        return $this;
    }

    /**
     * Add a new type map
     * @param $newType
     * @param null $map
     * @return $this
     */
    public function addType($newType, $map = null)
    {
        if (array_key_exists($newType, $this->typeMap)) {
            throw new \InvalidArgumentException("$newType is already mapped.");
        }
        if ($map && !in_array($map, array_values($this->typeMap))) {
            throw new \InvalidArgumentException("$map is not a supported type");
        }
        $this->typeMap[$newType] = $map === null ? $newType : $map;
        return $this;
    }

    /**
     * Get list of supported type maps
     * @return array
     */
    public function getTypeMap()
    {
        return $this->typeMap;
    }

    /**
     * Sets the trait to use for this table
     * @param string $name Trait name to use
     * @return $this
     */
    public function setTrait($name)
    {
        $supportedTraits = array_map(function ($val) {
            $vals = explode('\\', $val);
            return array_pop($vals);
        }, $this->supportedTraits);
        if (!in_array($name, $supportedTraits)) {
            throw new \InvalidArgumentException($name . ' is not a supported trait');
        }
        $this->dataTableConfig[$this->currentConfig]['trait'] = $name;

        return $this;
    }

    private function classUsesDeep($class, $autoload = false)
    {
        $traits = [];

        // Get traits of all parent classes
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while ($class = get_parent_class($class));

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            $newTraits = class_uses(array_pop($traitsToSearch), $autoload);
            $traits = array_merge($newTraits, $traits);
            $traitsToSearch = array_merge($newTraits, $traitsToSearch);
        };

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        return array_unique($traits);
    }

}
