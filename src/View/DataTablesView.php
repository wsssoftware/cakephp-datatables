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
        $this->autoLayout = false;
        $this->setTemplatePath(
            (!empty($this->request->getParam('prefix')) ? Inflector::camelize($this->request->getParam('prefix')) . DS : '') . $this->request->getParam('controller') . DS . 'datatables');
        $this->loadHelper('DataTables.DataTables');
    }
}
