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

namespace DataTables\Controller;

use Cake\Error\FatalErrorException;
use Cake\Http\ServerRequest;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\View\ViewBuilder;

/**
 * CakePHP DataTablesComponent
 *
 * @property \DataTables\Controller\Component\DataTablesComponent $DataTables
 * @method ViewBuilder viewBuilder()
 * @method ServerRequest getRequest()
 * @method \Controller set($name, $value = null)
 * @author allan
 */
trait FocSearchRequestTrait
{

    /**
     * @var callable
     */
    private $focSearchDataTableBeforeAjaxFunction = null;

    /**
     * @var callable
     */
    private $focSearchDataTableAfterAjaxFunction = null;

    /**
     * Set a function to be exec before ajax request
     * @param callable $dataTableBeforeAjaxFunction
     */
    public function setFocSearchDataTableBeforeAjaxFunction(callable $dataTableBeforeAjaxFunction)
    {
        if (!is_callable($dataTableBeforeAjaxFunction)) {
            throw new FatalErrorException(__d("datatables", "the parameter must be a function"));
        }
        $this->focSearchDataTableBeforeAjaxFunction = $dataTableBeforeAjaxFunction;
    }

    /**
     * Set a function to be exec after ajax request
     * @param callable $dataTableAfterAjaxFunction
     */
    public function setFocSearchDataTableAfterAjaxFunction(callable $dataTableAfterAjaxFunction)
    {
        if (!is_callable($dataTableAfterAjaxFunction)) {
            throw new FatalErrorException(__d("datatables", "the parameter must be a function"));
        }
        $this->focSearchDataTableAfterAjaxFunction = $dataTableAfterAjaxFunction;
    }

    /**
     * Ajax method to get data dynamically to the DataTables
     * @param string $config
     */
    public function getFocSearchDataTablesContent($config)
    {
        if (!empty($this->focSearchDataTableBeforeAjaxFunction) and is_callable($this->focSearchDataTableBeforeAjaxFunction)) {
            call_user_func($this->focSearchDataTableBeforeAjaxFunction);
        }

        $this->getRequest()->allowMethod('ajax');
        $configName = $config;
        $config = $this->DataTables->getDataTableConfig($configName);
        $params = $this->getRequest()->getQuery();
        $this->viewBuilder()->setClassName('DataTables.DataTables');
        $this->viewBuilder()->setTemplate(Inflector::underscore($configName));

        $order = [];
        if (!empty($params['order'])) {
            foreach ($params['order'] as $item) {
                $order[$config['columnsIndex'][$item['column']]] = $item['dir'];
            }
        }

        /** @var Table $Table */
        $Table = $this->{$config['table']};

        $results = $Table
            ->find('search', [
                'search' => $this->getRequest()->getQuery(),
            ]);

        if ($config['finder'] != 'all') {
            $results->find($config['finder']);
        }

        if (!empty($params['search']['value'])) {
            $Schema = $Table->getSchema();
            if ($displayField = $Table->getDisplayField()) {
                if ($Schema->getColumnType($displayField) == 'string') {
                    $cond = [
                        "$displayField like" => "%{$params['search']['value']}%",
                    ];
                } else {
                    $cond = [
                        "$displayField" => "{$params['search']['value']}",
                    ];
                }
                $results->where($cond);
            } else {
                throw new \UnexpectedValueException("displayField not defined for " . $config['table']);
            }
        }

        $countQuery = clone($results);

        $results
            ->limit($params['length'])
            ->offset($params['start'])
            ->order($order);

        $resultInfo = [
            'draw' => (int)$params['draw'],
            'recordsTotal' => (int)$countQuery->count(),
            'recordsFiltered' => (int)$results->count()
        ];

        $this->set([
            'results' => $results,
            'resultInfo' => $resultInfo,
        ]);

        if (!empty($this->focSearchDataTableAfterAjaxFunction) and is_callable($this->focSearchDataTableAfterAjaxFunction)) {
            call_user_func($this->focSearchDataTableAfterAjaxFunction);
        }
    }

}
