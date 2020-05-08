ConfigBundle
############

`ConfigBundle` is a class that store a table configuration. It will be used to draw the table html, to create the
JavaScript, and to get the table data. It have three principal Objects attributes, are they:

**Columns**: With this object, you can manage the columns of your table, be it database column or not. You can create,
edit and delete a column. Each column have many attributes that you can use to customize it options.

**Options**: With this object, you can customize your table with almost all DataTables library options.

**Query**: With this object, you can put some business rules for the table data, for example, you can get only the users
where status is active in the table UsersDataTable.

Additional Reading
==================

.. toctree::
    :maxdepth: 1

    /tables/config-bundle/columns
    /tables/config-bundle/options
    /tables/config-bundle/query