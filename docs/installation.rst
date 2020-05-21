Installation
############

CakePHP DataTables plugins has a few requirements:

- The same minimum environment of CakePHP 4.
- json PHP extension.
- DataTables library and it plugins (if required).
- jQuery 1 or 3.

.. tip::

    You can use the :doc:`Local Resources </tables/config-bundle/resources>` to load all the DataTables libraries dependencies and
    jQuery.

.. note::
    The main function of this plugin is create dynamic HTML tables using DataTables library, so, doesn't make sense use it
    this without a configured data source in your application, because you need data. DataTables plugin will require it
    and its respective ORM classes. To see more about data source and ORM classes, go to `this link <https://book.cakephp.org/4/en/orm.html>`_.

Installation steps
------------------

Before use the plugin you will need do somethings to install and configure it.

Requiring plugin using composer
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You need load the plugin inside your application using composer's ``require``
command::

    composer require wsssoftware/cakephp-datatables:^4.0

Loading plugin
^^^^^^^^^^^^^^

Load the plugin by adding the following statement in your project's ``src/Application.php``::

    public function bootstrap(): void
    {
        parent::bootstrap();
        $this->addPlugin('DataTables');
        //OR
        $this->addPlugin(\DataTables\Plugin::class);
    }

OR using cake shell in ``bin folder``::

    cake plugin load DataTables

Loading helper
^^^^^^^^^^^^^^

Load the helper by adding the following statement in your project's ``src/View/AppView.php``::

    use Cake\View\View;
    use DataTables\View\Helper\DataTablesHelper;

    /**
     * Application View
     *
     * @property DataTablesHelper DataTables
     */
    class AppView extends View
    {

        /**
         * Initialization hook method.
         *
         * @return void
         */
        public function initialize(): void
        {
            $this->loadHelper('DataTables.DataTables');
        }

Loading component
^^^^^^^^^^^^^^^^^

.. tip::
    This step is not mandatory, but if you need to edit any DataTables configuration inside a controller for a specific
    action, you will need to load the component.

Load the component by adding the following statement in your project's ``src/Controller/AppController.php``::

    use Cake\Controller\Controller;
    use DataTables\Controller\Component\DataTablesComponent;

    /**
     * Application Controller
     *
     * @property DataTablesComponent DataTables
     */
    class AppController extends Controller
    {

        /**
         * Initialization hook method.
         *
         * @return void
         */
        public function initialize(): void
        {
            $this->loadComponent('DataTables.DataTables');
        }

Setting the script renderer
^^^^^^^^^^^^^^^^^^^^^^^^^^^

You must to call the `View::fetch()` with the script block name passed as parameter to plugin render tables scripts. The
plugin use the same script block of :doc:`Local Resources </tables/config-bundle/resources>`:: that by default is `script`. Is recommended
that you call the fetch method above the **</body>** close tag like example below::

        ...

        <?= $this->fetch('script') ?>
    </body>
    </html>

.. tip::
    If you want to use the :doc:`Local Resources </tables/config-bundle/resources>` class to load yours library dependencies files, you must
    to have the `View::fetch()` with the css block name passed as parameter. You can change the block name, but by default
    is `css`. Is recommend that you call the fetch method above the **</head>** close tag like example below::

        ...

            <?= $this->fetch('css') ?>
        </head>

