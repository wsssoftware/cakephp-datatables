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
use Cake\Error\FatalErrorException;
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
    private $defaultOptions = [];

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
        $this->defaultOptions = $config;
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
        return $this->DataTablesConfig->setDataTableConfig(Inflector::camelize($name), $this->defaultOptions);
    }

    /**
     * Set the views vars fot the selected configs
     * @param string $configs
     * @throws FatalErrorException
     */
    public function setViewVars($configs)
    {
        $configItems = [];
        if (is_array($configs)) {
            foreach ($configs as $config) {
                if (empty($this->configs[$config])) {
                    throw new FatalErrorException(__d('datatables', 'The requested DataTables config was not found'));
                } else {
                    if (empty($this->configs[$config]['columns'])) {
                        throw new FatalErrorException(__d('datatables', 'The requested DataTables config must have at least one column'));
                    }
                }
                $configItems[$config] = $this->configs[$config];
            }
            $this->controller->set(["DataTables" => $configItems]);
        }
        if (is_string($configs)) {
            if (empty($this->configs[$configs])) {
                throw new FatalErrorException(__d('datatables', 'The requested DataTables config was not found'));
            } else {
                if (empty($this->configs[$configs]['columns'])) {
                    throw new FatalErrorException(__d('datatables', 'The requested DataTables config must have at least one column'));
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
    public function getDataTableConfigs()
    {
        return $this->configs;
    }

    /**
     * Get a specific config
     * @param string $name
     * @return array
     * @throws FatalErrorException
     */
    public function getDataTableConfig($name)
    {
        if (empty($this->configs[$name])) {
            throw new FatalErrorException(__d('datatables', 'The requested DataTables config was not found'));
        }
        return $this->configs[$name];
    }


}
