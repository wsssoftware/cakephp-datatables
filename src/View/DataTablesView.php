<?php

namespace DataTables\View;

use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
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
        $this->templatePath($this->request->param('controller').DS.'datatables');
        $this->loadHelper('DataTables.DataTables');
    }
}
