<?php

namespace DataTables\Controller;

use Cake\Error\FatalErrorException;
use \Cake\Utility\Inflector;

/**
 * CakePHP DataTablesComponent
 *
 * @property \DataTables\Controller\Component\DataTablesComponent $DataTables
 *
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
     * @param callable $dataTableBeforeAjaxFunction
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
     * @param callable $dataTableAfterAjaxFunction
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
        if (!empty($this->dataTableBeforeAjaxFunction) and is_callable($this->dataTableBeforeAjaxFunction)) {
            call_user_func($this->dataTableBeforeAjaxFunction);
        }

        $this->request->allowMethod('ajax');
        $configName = $config;
        $config = $this->DataTables->getDataTableConfig($configName);
        $params = $this->request->query;
        $this->viewBuilder()->className('DataTables.DataTables');
        $this->viewBuilder()->template(Inflector::underscore($configName));

        // searching all fields
        $where = [];
        if (!empty($params['search']['value'])) {
            foreach ($config['columns'] as $column) {
                if ($column['searchable'] == true) {
                    $explodedColumnName = explode(".", $column['name']);
                    if (count($explodedColumnName) == 2) {
                        if ($explodedColumnName[0] === $this->{$config['table']}->getAlias()) {
                            $columnType = !empty($this->{$config['table']}->getSchema()->getColumn($explodedColumnName[1])['type']) ? $this->{$config['table']}->getSchema()->getColumn($explodedColumnName[1])['type'] : 'string';
                        } else {
                            $columnType = !empty($this->{$config['table']}->{$explodedColumnName[0]}->getSchema()->getColumn($explodedColumnName[1])['type']) ? $this->{$config['table']}->getSchema()->getColumn($explodedColumnName[1])['type'] : 'string';
                        }
                    } else {
                        $columnType = !empty($this->{$config['table']}->getSchema()->getColumn($column['name'])['type']) ? $this->{$config['table']}->getSchema()->getColumn($column['name'])['type'] : 'string';
                    }
                    switch ($columnType) {
                        case "integer":
                            $where['OR']["{$column['name']}"] = "{$params['search']['value']}";
                            break;
                        case "string":
                            $where['OR']["{$column['name']} like"] = "%{$params['search']['value']}%";
                            break;
                        case "boolean":
                            $where['OR']["{$column['name']} like"] = "%{$params['search']['value']}%";
                            break;
                        case "datetime":
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

            $operator = '';
            $columnType = $config['columns'][$paramColumn['name']]['type'];

            switch ($columnType) {
                case 'text':
                    $operator = ' LIKE';
                    if (strpos($columnSearch, '%') === false) {
                        $columnSearch = '%' . $columnSearch . '%';
                    }
                    $where[] = [$paramColumn['name'] . $operator => $columnSearch];
                break;
            }
        }

        $order = [];
        if (!empty($params['order'])) {
            foreach ($params['order'] as $item) {
                $order[$config['columnsIndex'][$item['column']]] = $item['dir'];
            }
        }

        foreach ($config['columns'] as $key => $item) {
            if ($item['database'] == true) {
                $select[] = $key;
            }
        }

        if (!empty($config['databaseColumns'])) {
            foreach ($config['databaseColumns'] as $key => $item) {
                $select[] = $item;
            }
        }

        $results = $this->{$config['table']}->find($config['finder'], $config['queryOptions'])
            ->select($select)
            ->where($where)
            ->limit($params['length'])
            ->offset($params['start'])
            ->order($order);


        $resultInfo = [
            'draw' => (int)$params['draw'],
            'recordsTotal' => (int)$this->{$config['table']}->find('all', $config['queryOptions'])->count(),
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
