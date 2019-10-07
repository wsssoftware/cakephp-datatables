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

use Cake\Core\Configure;
use Cake\Error\FatalErrorException;
use Cake\Http\ServerRequest;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\View\ViewBuilder;
use Controller;
use DataTables\Controller\Component\DataTablesComponent;
use DataTables\View\DataTablesView;

/**
 * CakePHP DataTablesComponent
 *
 * @property DataTablesComponent $DataTables
 * @property Table $DtConfigTable
 * @method ViewBuilder viewBuilder()
 * @method ServerRequest getRequest()
 * @method Controller set($name, $value = null)
 * @author allan
 */
trait DataTablesAjaxRequestTrait
{

    /**
     * @var callable
     */
    private $dataTableBeforeAjaxFunction = null;

    /**
     * @var callable
     */
    private $dataTableAfterAjaxFunction = null;

    /**
     * Set a function to be exec before ajax request
     * @param callable $dataTableBeforeAjaxFunction set callable function
     */
    public function setDataTableBeforeAjaxFunction(callable $dataTableBeforeAjaxFunction)
    {
        if (!is_callable($dataTableBeforeAjaxFunction)) {
            throw new FatalErrorException(__d("datatables", "the parameter must be a function"));
        }
        $this->dataTableBeforeAjaxFunction = $dataTableBeforeAjaxFunction;
    }

    /**
     * Set a function to be exec after ajax request
     * @param callable $dataTableAfterAjaxFunction set callable function
     */
    public function setDataTableAfterAjaxFunction(callable $dataTableAfterAjaxFunction)
    {
        if (!is_callable($dataTableAfterAjaxFunction)) {
            throw new FatalErrorException(__d("datatables", "the parameter must be a function"));
        }
        $this->dataTableAfterAjaxFunction = $dataTableAfterAjaxFunction;
    }

    /**
     * Ajax method to get data dynamically to the DataTables
     * @param string $config
     */
    public function getDataTablesContent($config)
    {
        if (!empty($this->dataTableBeforeAjaxFunction) && is_callable($this->dataTableBeforeAjaxFunction)) {
            call_user_func($this->dataTableBeforeAjaxFunction);
        }

        if (Configure::read('debug') !== true) {
            $this->getRequest()->allowMethod('ajax');
        }
        $configName = $config;
        $config = $this->DataTables->getDataTableConfig($configName);
        $params = $this->getRequest()->getQuery();
        $this->viewBuilder()->setClassName(DataTablesView::class);
        $this->viewBuilder()->setTemplate(Inflector::underscore($configName));
        if (empty($this->{$config['table']})) {
            $this->DtConfigTable = TableRegistry::getTableLocator()->get($config['table']);
        } else {
            $this->DtConfigTable = $this->{$config['table']};
        }

        // searching all fields
        $where = [];
        if (!empty($params['search']['value'])) {
            foreach ($config['columns'] as $column) {
                if ($column['searchable'] == true) {
                    $explodedColumnName = explode(".", $column['name']);
                    if (count($explodedColumnName) == 2) {
                        if ($explodedColumnName[0] === $this->DtConfigTable->getAlias()) {
                            $columnType = !empty($this->DtConfigTable->getSchema()->getColumn($explodedColumnName[1])['type']) ? $this->DtConfigTable->getSchema()->getColumn($explodedColumnName[1])['type'] : 'string';
                        } else {
                            $columnType = !empty($this->DtConfigTable->{$explodedColumnName[0]}->getSchema()->getColumn($explodedColumnName[1])['type']) ? $this->DtConfigTable->getSchema()->getColumn($explodedColumnName[1])['type'] : 'string';
                        }
                    } else {
                        $columnType = !empty($this->DtConfigTable->getSchema()->getColumn($column['name'])['type']) ? $this->DtConfigTable->getSchema()->getColumn($column['name'])['type'] : 'string';
                    }
                    switch ($columnType) {
                        case "integer":
                            if (is_numeric($params['search']['value'])) {
                                $where['OR']["{$column['name']}"] = $params['search']['value'];
                            }
                            break;
                        case "decimal":
                            if (is_numeric($params['search']['value'])) {
                                $where['OR']["{$column['name']}"] = $params['search']['value'];
                            }
                            break;
                        case "string":
                            $where['OR']["{$column['name']} like"] = "%{$params['search']['value']}%";
                            break;
                        case "text":
                            $where['OR']["{$column['name']} like"] = "%{$params['search']['value']}%";
                            break;
                        case "boolean":
                            $where['OR']["{$column['name']} like"] = "%{$params['search']['value']}%";
                            break;
                        case "datetime":
                            $where['OR']["{$column['name']} like"] = "%{$params['search']['value']}%";
                            break;
                        default:
                            $where['OR']["{$column['name']} like"] = "%{$params['search']['value']}%";
                            break;
                    }
                }
            }
        }

        // searching individual field
        foreach ($params['columns'] as $paramColumn) {
            $columnSearch = $paramColumn['search']['value'];
            if (!$columnSearch || !$paramColumn['searchable']) {
                continue;
            }

            $explodedColumnName = explode(".", $paramColumn['name']);
            if (count($explodedColumnName) == 2) {
                if ($explodedColumnName[0] === $this->DtConfigTable->getAlias()) {
                    $columnType = !empty($this->DtConfigTable->getSchema()->getColumn($explodedColumnName[1])['type']) ? $this->DtConfigTable->getSchema()->getColumn($explodedColumnName[1])['type'] : 'string';
                } else {
                    $columnType = !empty($this->DtConfigTable->{$explodedColumnName[0]}->getSchema()->getColumn($explodedColumnName[1])['type']) ? $this->DtConfigTable->getSchema()->getColumn($explodedColumnName[1])['type'] : 'string';
                }
            } else {
                $columnType = !empty($this->DtConfigTable->getSchema()->getColumn($paramColumn['name'])['type']) ? $this->DtConfigTable->getSchema()->getColumn($paramColumn['name'])['type'] : 'string';
            }
            switch ($columnType) {
                case "integer":
                    if (is_numeric($params['search']['value'])) {
                        $where[] = [$paramColumn['name'] => $columnSearch];
                    }
                    break;
                case "decimal":
                    if (is_numeric($params['search']['value'])) {
                        $where[] = [$paramColumn['name'] => $columnSearch];
                    }
                    break;
                case 'string':
                    $where[] = ["{$paramColumn['name']} like" => "%$columnSearch%"];
                    break;
                default:
                    $where[] = ["{$paramColumn['name']} like" => "%$columnSearch%"];
                    break;
            }
        }

        $order = [];
        if (!empty($params['order'])) {
            foreach ($params['order'] as $item) {
                $order[$config['columnsIndex'][$item['column']]] = $item['dir'];
            }
        }
        if (!empty($order)) {
            unset($config['queryOptions']['order']);
        }

        foreach ($config['columns'] as $key => $item) {
            if ($item['database'] == true) {
                $select[] = $key;
            }
        }

        if (!empty($config['databaseColumns'])) {
            foreach ($config['databaseColumns'] as $key => $item) {
                $select[] = $key;
                if ($item['searchable']) {
                    $where['OR']["{$key} like"] = "%{$params['search']['value']}%";
                }
            }
        }

        /** @var array $select */
        /** @var Query $results */
        $results = $this->DtConfigTable->find($config['finder'], $config['queryOptions'])
            ->select($select)
            ->where($where)
            ->limit($params['length'])
            ->offset($params['start'])
            ->order($order);

        $resultInfo = [
            'draw' => (int)$params['draw'],
            'recordsTotal' => (int)$this->DtConfigTable->find('all', $config['queryOptions'])->count(),
            'recordsFiltered' => (int)$results->count()
        ];

        $this->set([
            'results' => $results,
            'resultInfo' => $resultInfo,
        ]);

        if (!empty($this->dataTableAfterAjaxFunction) and is_callable($this->dataTableAfterAjaxFunction)) {
            call_user_func($this->dataTableAfterAjaxFunction);
        }
    }

}
