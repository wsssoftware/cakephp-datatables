<?php

namespace DataTables\Controller;

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

    public function getDataTablesContent($config)
    {
        $configName = $config;
        $config     = $this->DataTables->getConfig($configName);
        $params     = $this->request->query;
        $this->viewBuilder()->className('Ajax');
        $this->viewBuilder()->autoLayout(false);

        $this->viewBuilder()->layout('ajax');
        $this->viewBuilder()->template('datatables/' . Inflector::underscore($configName));




        $where = [];
        if (!empty($params['search']['value']))
        {
            foreach ($config['columns'] as $colums)
            {
                if($colums['searchable'] == true)
                {
                    $where['OR'][$colums['name'] . ' like'] =  "%{$params['search']['value']}%";
                }
            }
        }
        


        $order = [];
        if (!empty($params['order']))
        {
            foreach ($params['order'] as $item)
            {
                $order[$config['columnsIndex'][$item['column']]] = $item['dir'];
            }
        }

        foreach ($config['columns'] as $key => $item)
        {
            if ($item['database'] == true)
            {
                $select[] = $key;
            }
        }

        if (!empty($config['databaseColumns']))
        {
            foreach ($config['databaseColumns'] as $key => $item)
            {
                $select[] = $item;
            }
        }

        $results = $this->{$config['table']}->find('all', $config['queryOptions'])
                ->select($select)
                ->where($where)
                ->limit($params['length'])
                ->offset($params['start'])
                ->order($order);

        
        $resultInfo = [
            'draw'            => (int) $params['draw'],
            'recordsTotal'    => (int) $this->{$config['table']}->find('all', $config['queryOptions'])->count(),
            'recordsFiltered' => (int) $results->count()
        ];

        $this->set([
            'results'    => $results,
            'resultInfo' => $resultInfo,
        ]);
    }

}
