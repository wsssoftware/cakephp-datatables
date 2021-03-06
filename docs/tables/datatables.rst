.. php:namespace:: DataTables\Table

DataTables
##########

.. php:class:: DataTables()

Classes inherited from **DataTables** are the classes that has two methods very important that is
called to apply the application business rules to a :doc:`ConfigBundle </tables/config-bundle>` from a table. They
are saved on ``src/DataTables/`` folder and are postfixed with `DataTables`, so, Categories DataTables class will be
named `CategoriesDataTables`. You can easily :doc:`bake </tables/bake>` this class using the CakePHP bake shell.

Methods
-------

There are two methods, the `config` and `rowRenderer`, one to set configs and other to define how data will be rendered.

Config
^^^^^^

.. php:method:: config(ConfigBundle $configBundle)

This method has a :doc:`ConfigBundle </tables/config-bundle>` passed as param. Inside it
you will be able to set the columns, DataTables library options and special Query conditions for the table. Its
structure is::

    /**
     * Will implements all the table configuration.
     *
     * @param \DataTables\Table\ConfigBundle $configBundle
     * @return void
     */
    public function config(ConfigBundle $configBundle) {
    }

Row Renderer
^^^^^^^^^^^^

.. php:method:: rowRenderer(DataTablesView $appView, EntityInterface $entity, Renderer $renderer)

This method has a `DataTablesView`, `Entity` and `Renderer` objects passed as param. Inside it
the developer will be able to define how each row column will be rendered. DataTablesView is inheritance from `AppView` and
has access to all helpers and `View` methods. The entity has all needle dada, the developer can even do `if` and
others conditionals as required by business rule. Renderer is a object that will storage each column value set by the developer.
Each row render will call this method and the non set columns will be autogenerated with a warning. Its structure is::

    /**
     * @param \DataTables\View\DataTablesView $appView
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \DataTables\Table\Renderer $renderer
     * @return void
     */
    public function rowRenderer(DataTablesView $appView, EntityInterface $entity, Renderer $renderer) {
    }
