<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DataTables\Controller\Component;

use Cake\Controller\Component;
use Cake\Utility\Inflector;

/**
 * CakePHP DataTableConfigComponent
 * @author allan
 */
class DataTablesConfigComponent extends Component
{

    private $dataTableConfig = [];
    private $currentConfig   = null;
    private $defaultOptions = [];

    public function initialize(array $config)
    {
        $this->dataTableConfig = &$config['DataTablesConfig'];
        parent::initialize($config);
    }

    /**
     * Set initial config name
     * @param string $name
     * @return $this
     */
    public function setDataTableConfig($name, $defaultOptions)
    {
        $this->defaultOptions = $defaultOptions;
        $this->currentConfig                   = $name;
        $this->dataTableConfig[$name]['id']    = 'dt' . $name;
        $this->dataTableConfig[$name]['table'] = $name;
        $this->dataTableConfig[$name]['queryOptions'] = [];
        $this->dataTableConfig[$name]['options'] = $this->defaultOptions;
        $this->dataTableConfig[$name]['finder'] = "all";
        return $this;
    }
    
    /**
     * Set a finder type from method "find()"
     * @param string $finder
     * @return $this
     */
    public function finder($finder = "all") {
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
     * @param type $name
     * @param array $options
     * @return DataTablesConfigComponent
     */
    public function column($name, array $options = [])
    {
        if (!empty($options['order']))
        {
            if (!in_array($options['order'], ['asc', 'desc']))
            {
                unset($options['order']);
            }
        }
        $options += [
            'label'          => $name,
            'database'       => true,
            'searchable'     => true,
            'orderable'      => true,
            'className'      => null,
            'orderDataType'  => 'dom-text',
            'type'           => 'text',
            'name'           => $name,
            'visible'        => true,
            'width'          => null,
            'defaultContent' => null,
            'contentPadding' => null,
            'cellType'       => 'td',
        ];
        
        if($options['database'] === false)
        {
            $options['orderable'] = false;
            $options['searchable'] = false;
        }
        

        $this->dataTableConfig[$this->currentConfig]['columns'][$name] = $options;
        $this->dataTableConfig[$this->currentConfig]['columnsIndex'][] = $name;
        return $this;
    }

    /**
     * Set a database column to use in data render
     * @param string $name
     * @return $this
     */
    public function databaseColumn($name)
    {
        $this->dataTableConfig[$this->currentConfig]['databaseColumns'][] = $name;

        return $this;
    }

    /**
     * Set DataTables general configs
     * @param string $options
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

}
