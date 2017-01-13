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
 * CakePHP DataTablesComponent
 * 
 * @property \DataTables\Controller\Component\DataTablesConfigComponent $DataTablesConfig
 * 
 * @author allan
 */
class DataTablesComponent extends Component
{

    private $configs = [];

    /**
     *
     * @var \Cake\Controller\Controller
     */
    private $controller = null;

    /**
     * 
     * @param \Cake\Controller\ComponentRegistry $registry
     * @param array() $config
     */
    public function __construct($registry, $config = [])
    {
        $this->controller = $registry->getController();

        $this->components = [
            'DataTables.DataTablesConfig' => [
                'DataTablesConfig' => &$this->configs
            ]
        ];

        parent::__construct($registry, $config);
    }

    /**
     * Set config name
     * @param string $name
     * @return \DataTables\Controller\Component\DataTablesConfigComponent
     */
    public function createConfig($name)
    {
        return $this->DataTablesConfig->setConfig(Inflector::camelize($name));
    }

    /**
     * Set the views vars fot the selected configs
     * @param string $configs
     * @throws \Cake\Error\FatalErrorException
     */
    public function setViewVars($configs)
    {
        if (is_array($configs))
        {
            foreach ($configs as $config)
            {
                if (empty($this->configs[$config]))
                {
                    throw new \Cake\Error\FatalErrorException(__d('datatables', 'The requested DataTables config was not found'));
                } else
                {
                    if (empty($this->configs[$config]['columns']))
                    {
                        throw new \Cake\Error\FatalErrorException(__d('datatables', 'The requested DataTables config must have at least one column'));
                    }
                }
                $configItems[$config] = $this->configs[$config];
            }
            $this->controller->set(["DataTables" => $configItems]);
        }
        if (is_string($configs))
        {
            if (empty($this->configs[$configs]))
            {
                throw new \Cake\Error\FatalErrorException(__d('datatables', 'The requested DataTables config was not found'));
            } else
            {
                if (empty($this->configs[$configs]['columns']))
                {
                    throw new \Cake\Error\FatalErrorException(__d('datatables', 'The requested DataTables config must have at least one column'));
                }
            }
            $this->controller->set(["DataTables" => [
                    $configs => $this->configs[$configs]
            ]]);
        }
    }

    /**
     * Get all configs
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }
    
    /**
     * Get a specific config
     * @param string $name
     * @return array
     * @throws \Cake\Error\FatalErrorException
     */
    public function getConfig($name)
    {
        if(empty($this->configs[$name]))
        {
            throw new \Cake\Error\FatalErrorException(__d('datatables', 'The requested DataTables config was not found'));
        }
        
        return $this->configs[$name];
    }
    

}
