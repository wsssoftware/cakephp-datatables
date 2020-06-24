.. php:namespace:: DataTables\Table

Columns
#######

.. php:class:: Columns(ConfigBundle $configBundle)

Inside the ConfigBundle we have a Columns object from class ``DataTables\Table\Columns``. Its function is manage the
columns from table, so, you can add, edit, remove, list and other methods related with columns.

Basic Usage
===========

In short, you can use two kind of column, database and non database columns. Non database columns are used to some
custom business rules based in the entity data or in a simple case, make a action column. The database column in general
will show the data for a specific item from database.

Adding database column
^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: addDatabaseColumn(string $dataBaseField, ?int $index = null)

This method will add a new database column to the table, but first it will check if the column exists in table schema,
both for the table itself and for its relations. Its name must be unique for the table. As in CakePHP, the column name
words must be separated by underscore and the table name (optional) in CamelCase format, both separated by a dot. This
method will return a **Column** object that you can use to set some configurations for the created column. You can pass
the index to put the column in a specific position. Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
       $configBundle->Columns->addDatabaseColumn('id');

       $configBundle->Columns->addDatabaseColumn('created');
       $configBundle->Columns->addDatabaseColumn('modified');

       // Adding a column BelongsTo
       $configBundle->Columns->addDatabaseColumn('Categories.name');

       // Adding a column HasMany
       $configBundle->Columns->addDatabaseColumn('Tags.name');

    }

.. note::
    On each column added, the plugin automatically will select the field in query and will put contain associations if
    needed, so, the query will be build automatically according to your configuration. **BelongsTo** and **HasMany**
    associations will follow the same logical from CakePHP ou result entity.

Adding a custom database column
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: addCustomDatabaseColumn(FunctionExpression $functionExpression, string $asName, ?int $index = null)

With this method, you will able of do some custom sql finds like `CONCAT`, `SUM` and others. You must provide a
`FunctionExpression` instance that is the result of one of many methods that you can find in `FunctionsBuilder` that you
can get in `$configBundle->Columns->func()` method. Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $func = $configBundle->Columns->func()->concat(['id' => 'identifier', ' created in: ', 'created' => 'identifier']);
        $configBundle->Columns->addCustomDatabaseColumn($func, 'custom_field');

    }

.. note::
    When you use this method with joined tables you will need to join it manually with the `$configBundle->Query` object.
    With this `\DataTables\Table\QueryBaseState` object, you will can join the new table with a contain method or others
    joins methods.

Adding non database column
^^^^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: addNonDatabaseColumn(string $label, ?int $index = null)

This method will add a new non database column to the table. Its name must be a alphanumeric string and unique for the
the table. You can use this method to create columns with custom values as a sum or concatenate of two database fields
or a action column. This method will return a **Column** object that you can use to set some configurations for the
created column. You can pass the index to put the column in a specific position. Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
       $configBundle->Columns->addNonDatabaseColumn('total');
       $configBundle->Columns->addNonDatabaseColumn('action');
    }

.. note::
    When you use the a non database column, its **searchable** and **orderable** options will be disabled automatically.

Changing the index of a column
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: changeColumnIndex(string $columnName, int $index)

By default, the column index will follow the created order, if you want change the order, you can use this method in
your `DataTables` class or in controller using the `DataTables`  :doc:`Component </tables/customizing>`. Example of
usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('name');
        $configBundle->Columns->addDatabaseColumn('created');
        $configBundle->Columns->addDatabaseColumn('modified');
        $configBundle->Columns->addNonDatabaseColumn('action');
        $configBundle->Columns->addDatabaseColumn('id');

        $configBundle->Columns->changeColumnIndex('id', 0);
    }

Or::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')
        $columns->changeColumnIndex('id', 0);
    }

Getting created columns
^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: getColumns()

If you need get all configured columns, you can call this method, it will return a array will all **column** objects.
Example of usage::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')

        $columnTitles = [];
        foreach ($columns->getColumns() as $column) {
            $columnTitles[] = $column->getTitle();
        }
    }

Getting a column
^^^^^^^^^^^^^^^^

.. php:method:: getColumn(string $columnName)

If you need get a specific configured column, you can call this method, it will return a **column** object for the
requested column name. Example of usage::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')

        $columnTitle = $columns->getColumn('id')->getTitle();
    }

Getting a column by index
^^^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: getColumnByIndex(int $index)

If you need get a specific configured column, you can call this method, it will return a **column** object for the
requested column index. Example of usage::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')

        $columnTitle = $columns->getColumnByIndex(0)->getTitle();
    }

Getting a column index by name
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: getColumnIndexByName(string $columnName)

If you need know the index of a specific column, you can provide the column name to this method and it will return the
index. Example of usage::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')

        $columnIndex = $columns->getColumnIndexByName('Products.created');
    }

Getting a column name by index
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: getColumnNameByIndex(int $index)

If you need to know what the column name for a specific index, you can call this method passing a index number for it.
Example of usage::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')

        $columnName = $columns->getColumnNameByIndex(0);
    }

Deleting a column
^^^^^^^^^^^^^^^^^

.. php:method:: deleteColumn(string $columnName)

If you need remove a specific column from table, you can call this method passing a column name for it. Example of
usage::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')

        $columns->deleteColumn('action')
    }

Deleting all columns
^^^^^^^^^^^^^^^^^^^^

.. php:method:: deleteAllColumns()

If you want remove all created columns, you can call this method. Example of usage::

    /**
     * A example of controller action.
     */
    public function controllerAction()
    {
        $columns = $this->DataTables->getColumns('Products')

        $columns->deleteAllColumns()
        $columns->Columns->addDatabaseColumn('id');
        $columns->Columns->addDatabaseColumn('name');
        $columns->Columns->addDatabaseColumn('created');
        $columns->Columns->addDatabaseColumn('modified');
        $columns->Columns->addNonDatabaseColumn('action');
    }

Learning more
=============

.. toctree::
    :maxdepth: 1

    /tables/config-bundle/column
