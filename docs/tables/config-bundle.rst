.. php:namespace:: DataTables\Table

ConfigBundle
############

.. php:class:: ConfigBundle(string $checkMd5, string $dataTablesFQN)

`ConfigBundle` is a class that store a table configuration. It will be used to draw the table html, to create the
JavaScript, and to get the table data.


What is inside
==============

Inside this object, you will be able to access a `Columns` attribute that is a instance of ``DataTables\Table\Columns``.
With it, is possible manage the columns from your table. Other is `Options` that is a instance of ``DataTables\Table\Option\MainOption``.
With it, you can use almost all configurations and options from DataTables library. Finally we have the `Query` that is
a instance of ``DataTables\Table\QueryBaseState``. It is a object that allow you have control over the table query, such
as select some more columns from database table or do a `where` conditions for all the DataTables config.

How it works
============

Every time that you ask for a rendering of a table, the plugin will create a instance of this class using as base one
DataTables class that you pass as parameter. After constructed the instance, the plugin will call the method config of
the selected DataTables class a this will apply the application business rules to the current `ConfigBundle`. When debug
isn't on, they will do this long process only on first request, because after get the final result of instance the plugin
will save it on cache. In the next time, if cache exists and it is valid yet, the cache will be read and will return a
`ConfigBundle` that was generated previously. The plugin uses md5 to check plugin version and class content, so if the
developer do some change on the class, or the plugin is updated, the cache is automatic invalidated.

Learning more
=============

.. toctree::
    :maxdepth: 1

    /tables/config-bundle/columns
    /tables/config-bundle/column
    /tables/config-bundle/options
    /tables/config-bundle/query
    /tables/config-bundle/resources