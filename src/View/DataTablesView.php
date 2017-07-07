<?php

namespace DataTables\View;

use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Utility\Inflector;
use App\View\AppView;

/**
 * CakePHP DataTablesView
 * 
 * @author allan
 */
class DataTablesView extends AppView
{
    public $layout = 'DataTables.datatables';

    public function initialize()
    {
        parent::initialize();
        $this->layoutPath('/');
        $this->templatePath(
          (!empty($this->request->params['prefix']) ? Inflector::camelize($this->request->params['prefix']).DS : '').$this->request->param('controller').DS.'datatables');
        $this->loadHelper('DataTables.DataTables');
    }
}
