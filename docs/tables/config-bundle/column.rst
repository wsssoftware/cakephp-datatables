.. php:namespace:: DataTables\Table

Column
######

.. php:class:: Column(string $name, bool $database = true, array $columnSchema = [], string $associationPath = '')

After create a column with respective methods, a object column will be storage in columns array and returned in the
method to be configured.

Basic Usage
===========

We have some basics configuration about the column and its behavior. In this section you can discovery how to customize
and configure your column after create it.

Getting the column name
^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: getName()

With this method you can get the column name if needed. Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $column = $configBundle->Columns->addDatabaseColumn('id');

        // Will return 'ModelName.id'
        $columnName = $column->getName();

        $column = $configBundle->Columns->addNonDatabaseColumn('action');

        // Will return 'action'
        $columnName = $column->getName();
    }

Getting the column name
^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: getName()

With this method you can get the column name if needed. Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $column = $configBundle->Columns->addDatabaseColumn('id');

        // Will return 'ModelName.id'
        $columnName = $column->getName();

        $column = $configBundle->Columns->addNonDatabaseColumn('action');

        // Will return 'action'
        $columnName = $column->getName();
    }

Checking if is database column
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. php:method:: isDatabase()

This method will return true if the column is a database column. Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->isDatabase()) {
                $databaseCount++;
            }
        }
    }

Getting column schema
^^^^^^^^^^^^^^^^^^^^^

.. php:method:: getColumnSchema(string $name = null)

If the field is database, this method will return the column schema. Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columnSchema = $configBundle->Columns->addDatabaseColumn('id')->getColumnSchema();

        if ($columnSchema['type'] === 'integer') {
            // do something.
        }
    }

Cell type
^^^^^^^^^

Change the cell type created
for the column - either TD cells or TH cells.

This can be useful as TH cells have semantic meaning in the table body, allowing them to act as a header for a row (you
may wish to add scope='row' to the TH elements using columns.createdCell option).

**Source:** `DataTables library: columns.cellType <https://datatables.net/reference/option/columns.cellType>`_.

Set method
""""""""""

.. php:method:: setCellType(?string $cellType)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setCellType('th');
    }


Get method
""""""""""

.. php:method:: getCellType()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->getCellType() === 'th') {
                // do something.
            }
        }
    }

Class name
^^^^^^^^^^

Quite simply this option adds a class to each cell in a column, regardless of if the table source is from DOM,
Javascript or Ajax. This can be useful for styling columns.

**Source:** `DataTables library: columns.className <https://datatables.net/reference/option/columns.className>`_.

Set method
""""""""""

.. php:method:: setClassName(?string $className)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setClassName('full-width');
    }


Get method
""""""""""

.. php:method:: getClassName()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->getClassName() === 'full-width') {
                // do something.
            }
        }
    }

Content padding
^^^^^^^^^^^^^^^

The first thing to say about this property is that generally you shouldn't need this!

Having said that, it can be useful on rare occasions. When DataTables calculates the column widths to assign to each
column, it finds the longest string in each column and then constructs a temporary table and reads the widths from that.
The problem with this is that "mmm" is much wider then "iiii", but the latter is a longer string - thus the calculation
can go wrong (doing it properly and putting it into an DOM object and measuring that is horribly slow!). Thus as a "work
around" we provide this option. It will append its value to the text that is found to be the longest string for the
column - i.e. padding.

**Source:** `DataTables library: columns.contentPadding <https://datatables.net/reference/option/columns.contentPadding>`_.

Set method
""""""""""

.. php:method:: setContentPadding(?string $contentPadding)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setContentPadding('aaaaaaaaaaaaaaaaaaaa');
    }


Get method
""""""""""

.. php:method:: getContentPadding()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if (strlen($column->getContentPadding()) >= 15) {
                // do something.
            }
        }
    }

Content padding
^^^^^^^^^^^^^^^

The first thing to say about this property is that generally you shouldn't need this!

Having said that, it can be useful on rare occasions. When DataTables calculates the column widths to assign to each
column, it finds the longest string in each column and then constructs a temporary table and reads the widths from that.
The problem with this is that "mmm" is much wider then "iiii", but the latter is a longer string - thus the calculation
can go wrong (doing it properly and putting it into an DOM object and measuring that is horribly slow!). Thus as a "work
around" we provide this option. It will append its value to the text that is found to be the longest string for the
column - i.e. padding.

**Source:** `DataTables library: columns.contentPadding <https://datatables.net/reference/option/columns.contentPadding>`_.

Set method
""""""""""

.. php:method:: setContentPadding(?string $contentPadding)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setContentPadding('aaaaaaaaaaaaaaaaaaaa');
    }


Get method
""""""""""

.. php:method:: getContentPadding()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if (strlen($column->getContentPadding()) >= 15) {
                // do something.
            }
        }
    }

Callback Created Cell
^^^^^^^^^^^^^^^^^^^^^

This is a callback function that is executed whenever a cell is created (Ajax source, etc) or read from a DOM source. It
can be used as a complement to columns.render allowing modification of the cell's DOM element (add background colour for
example) when the element is created (cells may not be immediately created on table initialisation if deferRender is
enabled, or if rows are dynamically added using the API (rows.add()).

This is the counterpart callback for rows, which use the createdRow option.

**Source:** `DataTables library: columns.createdCell <https://datatables.net/reference/option/columns.createdCell>`_.

**Learning more:** :doc:`Understanding plugin callbacks </tables/callbacks>`.

Set method
""""""""""

.. php:method:: callbackCreatedCell($bodyOrParams = [])

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->callbackCreatedCell('alert("created");');
    }

Order Data
^^^^^^^^^^

Allows a column's sorting to take either the data from a different (often hidden) column as the data to sort, or data
from multiple columns.

A common example of this is a table which contains first and last name columns next to each other, it is intuitive that
they would be linked together to multi-column sort. Another example, with a single column, is the case where the data
shown to the end user is not directly sortable itself (a column with images in it), but there is some meta data than can
be sorted (e.g. file name) - note that orthogonal data is an alternative method that can be used for this.

**Source:** `DataTables library: columns.orderData <https://datatables.net/reference/option/columns.orderData>`_.

Set method
""""""""""

.. php:method:: setOrderData($orderData)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setOrderData([0, 1]);
    }


Get method
""""""""""

.. php:method:: getOrderData()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->getOrderData() === [0, 1]) {
                // do something.
            }
        }
    }

Order Data Type
^^^^^^^^^^^^^^^

DataTables' primary order method (the ordering feature) makes use of data that has been cached in memory rather than
reading the data directly from the DOM every time an order is performed for performance reasons (reading from the DOM is
inherently slow). However, there are times when you do actually want to read directly from the DOM, acknowledging that
there will be a performance hit, for example when you have form elements in the table and the end user can alter the
values. This configuration option is provided to allow plug-ins to provide this capability in DataTables.

Please note that there are no columns.orderDataType plug-ins built into DataTables, they must be added separately. See
the DataTables sorting plug-ins page for further information.

**Source:** `DataTables library: columns.orderDataType <https://datatables.net/reference/option/columns.orderDataType>`_.

Set method
""""""""""

.. php:method:: setOrderDataType(?string $orderDataType)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setOrderDataType('dom-checkbox');
    }


Get method
""""""""""

.. php:method:: getOrderDataType()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->getOrderDataType() === 'dom-checkbox') {
                // do something.
            }
        }
    }

Order Sequence
^^^^^^^^^^^^^^

You can control the default ordering direction, and even alter the behaviour of the order handler (i.e. only allow
ascending sorting etc) using this parameter.

**Source:** `DataTables library: columns.orderSequence <https://datatables.net/reference/option/columns.orderSequence>`_.

Set method
""""""""""

.. php:method:: setOrderSequence(array $orderSequence = [])

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setOrderSequence(["desc", "asc", "asc"]);
    }


Get method
""""""""""

.. php:method:: getOrderSequence()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if (in_array('asc', $column->getOrderSequence())) {
                // do something.
            }
        }
    }

Orderable
^^^^^^^^^

Using this parameter, you can remove the end user's ability to order upon a column. This might be useful for generated
content columns, for example if you have 'Edit' or 'Delete' buttons in the table.

Note that this option only affects the end user's ability to order a column. Developers are still able to order a column
using the order option or the order() method if required.

**Source:** `DataTables library: columns.orderable <https://datatables.net/reference/option/columns.orderable>`_.

Set method
""""""""""

.. php:method:: setOrderable(?bool $orderable)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setOrderable(false);
    }


Checker method
""""""""""""""

.. php:method:: isOrderable()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->isOrderable()) {
                // do something.
            }
        }
    }

Searchable
^^^^^^^^^^

Using this parameter, you can define if DataTables should include this column in the filterable data in the table. You
may want to use this option to disable search on generated columns such as 'Edit' and 'Delete' buttons for example.

**Source:** `DataTables library: columns.searchable <https://datatables.net/reference/option/columns.searchable>`_.

Set method
""""""""""

.. php:method:: setSearchable(?bool $searchable)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setSearchable(false);
    }


Checker method
""""""""""""""

.. php:method:: isSearchable()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->isSearchable()) {
                // do something.
            }
        }
    }

Title
^^^^^

The titles of columns are typically read directly from the DOM (from the cells in the THEAD element), but it can often
be useful to either override existing values, or have DataTables actually construct a header with column titles for you
(for example if there is not a THEAD element in the table before DataTables is constructed). This option is available to
provide that ability.

Please note that when constructing a header, DataTables can only construct a simple header with a single cell for each
column. Complex headers with colspan and rowspan attributes must either already be defined in the document, or be
constructed using standard DOM / jQuery methods.

**Source:** `DataTables library: columns.title <https://datatables.net/reference/option/columns.title>`_.

Set method
""""""""""

.. php:method:: setTitle(string $title)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setTitle(__('Code'));
    }


Get method
""""""""""

.. php:method:: getTitle()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->getTitle() === 'Id') {
                // do something.
            }
        }
    }

Type
^^^^

When operating in client-side processing mode, DataTables can process the data used for the display in each cell in a
manner suitable for the action being performed. For example, HTML tags will be removed from the strings used for filter
matching, while sort formatting may remove currency symbols to allow currency values to be sorted numerically. The
formatting action performed to normalise the data so it can be ordered and searched depends upon the column's type.

**Source:** `DataTables library: columns.type <https://datatables.net/reference/option/columns.type>`_.

Set method
""""""""""

.. php:method:: setType(?string $type)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->setType('id')->setTitle('num');
    }


Get method
""""""""""

.. php:method:: getType()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->getType() === 'nul') {
                // do something.
            }
        }
    }

Visible
^^^^^^^^^^

DataTables and show and hide columns dynamically through use of this option and the column().visible() /
columns().visible() methods. This option can be used to get the initial visibility state of the column, with the API
methods used to alter that state at a later time.

This can be particularly useful if your table holds a large number of columns and you wish the user to have the ability
to control which columns they can see, or you have data in the table that the end user shouldn't see (for example a
database ID column).

**Source:** `DataTables library: columns.visible <https://datatables.net/reference/option/columns.visible>`_.

Set method
""""""""""

.. php:method:: setVisible(?bool $visible)

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $configBundle->Columns->addDatabaseColumn('id')->setVisible(false);
    }


Checker method
""""""""""""""

.. php:method:: isVisible()

Example of usage::

    /**
     * @param \DataTables\Table\ConfigBundle $configBundle
     */
    public function config(ConfigBundle $configBundle): void
    {
        $columns = $configBundle->Columns->getColumns();

        $databaseCount = 0;
        foreach ($columns as $column) {
            if ($column->isVisible()) {
                // do something.
            }
        }
    }



