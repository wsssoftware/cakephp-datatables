<?php

namespace DataTables\Controller;

use Cake\Error\FatalErrorException;
use Cake\Http\ServerRequest;
use Cake\ORM\Table;
use \Cake\Utility\Inflector;
use Cake\View\ViewBuilder;

/**
 * CakePHP DataTablesComponent
 *
 * @property \DataTables\Controller\Component\DataTablesComponent $DataTables
 * @property ServerRequest|null request
 * @method ViewBuilder viewBuilder()
 * @author allan
 */
trait FocSearchRequestTrait
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
        $params = $this->request->getQuery();
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
                'search' => $this->request->query,
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

        if (!empty($this->dataTableAfterAjaxFunction) and is_callable($this->dataTableAfterAjaxFunction)) {
            call_user_func($this->dataTableAfterAjaxFunction);
        }
    }

}
