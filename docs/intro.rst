CakePHP DataTables at a Glance
##############################

CakePHP DataTables plugin follows the same principles of CakePHP, it  is designed to make common web-development tasks
simple, and easy. It was developed to be light, clean code, fast and easy to use.

The goal of this overview is to introduce the general concepts and conventions of the plugin, and also explain how
DataTables library params, configurations, functions and others items are implemented in the plugin.

Conventions Over Configuration
==============================

CakePHP DataTables was build between two web giants, CakePHP and DataTables jQuery library. To make the code consistent
it follow a basics rules to preserve the coherence on the CakePHP side as well as on the DataTables side. This makes it
easier to use the plugin, because it is intuitive. See some examples below.

Plugin defaults
---------------

You can configure all the plugin defaults inside your configuration file such as **app.php**. For more info about this,
go to :doc:`configuration </configuration>` section.

DataTables library options
--------------------------

All library options has its name preserved in plugin using CamelCase format. When it is on a second or third level on
configuration tree such as **language.info**, the set method is **setLanguageInfo($value)**, and all its params respects
the format expected by the library, so, if you read the library documentation, you will know how to pass the param in
the right way.

DataTables library callbacks
----------------------------

All library callbacks also has its name preserved in plugin using CamelCase format. But in set method it will be
prefixed with **callback** word, so, for example, the callback **createdRow** set will be **callbackCreatedRow($bodyOrParams)**.
This may sound a little weird when a certain library callback ends with the word **callback**, like **footerCallback**,
because it setter will be **callbackFooterCallback($bodyOrParams)**. But this is to become more standardized!

Plugin Request Cycle
====================

Below you can see the plugin request cycle to render a table. This diagram is a more simplified version of `CakePHP Request Cycle <https://book.cakephp.org/4/en/intro.html#cakephp-request-cycle>`_.

.. figure:: /_static/plugin_request_cycle.svg
   :align: center
   :alt: Flow diagram showing a typical CakePHP request

The plugin request cycle starts with a user requesting a page that contain a table configured to render.
At a high level each plugin request goes through the following steps:

* Request 1 - Rendering the table structure.
    #. If user pass a :doc:`configuration </tables/customizing>` for ``options``, ``columns`` and/or ``query`` in ``Controller``
       action, the plugin ``Component`` will get the original objects, overwrite it and store on session with a unique key
       for that url.
    #. On ``View``, in the place that the user call the table render, the plugin will render a primitive html table
       structure. **Note:** If exist some custom ``options``, ``columns`` and/or ``query``, the plugin will merge it with
       the default configuration to use in next steps.
    #. If auto resources isn't disabled, the plugin will load all configured library dependencies.
    #. Yet in ``View``, if user call some table render, the plugin will generate the jQuery script of all tables that
       need to have their settings created.
    #. The response will be delivered to user. Every first load, so as well every changes on table filter, will trigger
       a **Request 2 or subsequent** to load data inside the table.

* Request 2..n - Requesting table data.
    #. The request contain all it filters passed by **GET** or **POST**. The ``Controller`` will use this to get the right
       data intended by user to render in table. **Note:** If exist some custom ``options``, ``columns`` and/or ``query``,
       the plugin will merge it with the default configuration to use in next steps.
    #. The ``View`` will apply the user custom render for each column of each row, if it not exists for one or more
       column, the plugin will try do a auto render for it. This auto render will stay blinking as a warning for user.
    #. The ``View`` will compile all this information in a json response that the DataTables library will use to feed
       the table.