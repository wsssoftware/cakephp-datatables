# DataTables plugin for CakePHP 3.7 or higher



**Note:** Hey, English is not my primary language, if you find any error here in this documentation or have an idea how to improve it, I'll be happy to hear it. I say the same for the plugin code.

There are currently some plugins that implement the jQuery DataTables library in CakePHP 3.x. This library on the "client" side is a powerful tool for showing and managing data. But most of the plugins that implement it are no more than small helpers, because they do not provide the complete automatic connection between server side and client side, which in my case (speaking from a developer's point of view) is not compatible as our "automagic" framework.
Why use this plugin for DataTables:

  - Easy installation;
  - All table logic stays in the controller and its view is just for formatting data;
  - Easy to use due to great resemblance to Cake;
  - Wide range of customization and options.


This plugin is under development by [Allan Carvalho]. Although it already has a certain maturity, **errors** and **failures** can happen, then, help him to improve it making this one of the best Cake plugin.


### Requirements

Don't worry, you only need:

* [Composer] - Not mandatory but highly recommended;
* [DataTables library] - Choose what you need and put it in your code (DataTables has a wide variety of download options);
* [CakePHP 3.7] or higher - Recommended always use the latest available version;

**Note:** `DataTablesView` extends from `AppView`. Then it must exist.


### Installation

There are two recommended ways to install this plugin:

**1** - Using `composer.json`
```javascript
"require": {
    "allanmcarvalho/cakephp-datatables": "1.*"
}
```

**2** - Using `prompt`

```sh
$ php composer.phar require allanmcarvalho/cakephp-datatables
```


### Basic configuration

**1** - In `bootstrap.php` load the plugin
```php
Plugin::load('DataTables');
```

**2** - In the `ExampleController.php` that you will use DataTables use the `DataTablesAjaxRequestTrait` and load `DataTablesComponent`
```php

namespace App\Controller;

use DataTables\Controller\DataTablesAjaxRequestTrait;

class ExampleController extends AppController
{
    use DataTablesAjaxRequestTrait;
     public function initialize()
    {
        parent::initialize();
        $this->loadComponent('DataTables.DataTables');
        
        //OR
        
        $this->loadComponent('DataTables.DataTables', ['language' => ['url => 'Portuguese-Brasil.json']]);
    }
```
**Note:** `Trait` is required in controller that you will use DataTables because it implements the ajax `action` that returns the data to the table.

**Note:** The second way to load the component shows you how to pass default options to the DataTables library, so all `configs` will get it by default (unless you overwrite it).

**3** - In `AppView.php` load `DataTablesHelper`

```php
...
class AppView extends View
{
    public function initialize()
        {
            $this->loadHelper('DataTables.DataTables');
        }
...
```

**4** - In `Templates/Layout/current_layout.php` after `jQuery.js` and `DataTables.js` do

```php
...
        <?= $this->DataTables->setJs() ?>
    </body>
</html>
...
```

## How to use

**1** - Create a configuration in `initialize` method from controller

```php
...
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('DataTables.DataTables');
        $this->DataTables->createConfig('Users')
                ->column('Users.name', ['label' => 'Name'])
                ->column('Users.email', ['label' => 'Email'])
                ->column('Users.age', ['label' => 'Age'])
                ->column('actions', ['label' => 'Actions', 'database' => false]);

        $this->DataTables->createConfig('UsersActive')
                ->table('Users')
                ->column('UserStatuses.id', ['label' => 'Id'])
                ->column('UserStatuses.name', ['label' => 'Email'])
                ->column('actions', ['label' => 'Actions', 'database' => false]);
    }
...
```
**Note:** When `->table('TableName')` method is omitted the configuration name is taken as the name of the database table.

**Note:** You can create as many configurations as you need, as long as their names are unique.

**Note:** When use `AuthComponent` to allow a action that contain DataTables you must allow the action `getDataTablesContent` too in this controller.

**2** - Setting the `viewsVars` for chosen `configuration(s)` in the Controller action

```php
...
    public function index()
    {
        $this->DataTables->setViewVars('Users');
        //or
        $this->DataTables->setViewVars(['Users', 'UserStatuses']);
    }
...
```
**Note:** You must set the `viewVars` for all `configurations` to be used.

**3** - Setting the `render` for chosen `configuration` in the action `view.ctp`

```php
...
    <?= $this->DataTables->render('Users') ?>
    <!-- OR -->    
    <?= $this->DataTables->render('UserStatuses', ['class' => 'table table-striped table-bordered dataTable no-footer', 'OthersAttr' => '...']) ?>
...
```
**Note:** You must call the rendering method for all the configuration that you want to create a DataTables

**4** - Setting the `ajax` response view in `Template/{Controller}/datatables/user_statuses.ctp`

```php
<?php
foreach ($results as $result)
{
    $this->DataTables->prepareData([
        $result->id,
        h($result->name),
        $this->Html->link('Delete', ['action' => 'delete', $result->id])
    ]);
}
echo $this->DataTables->response();
```
**Note:** This code is the same for all configurations, only changing the contents within the array of the `$this->DataTables->prepareData([])` method.

## Useful examples

**1** - Trivial : Displaying association values in datatables

Let's say you have a `department_id` in the `Users` table, referencing a department in the `Departments` table, and you want to display the department name in your datatable.

First you'll have to add the association in the configuration, via the `queryOptions()` method:

```php
$this->DataTables->createConfig('Users')
    ->queryOptions(['contain' => ['Departments' => ['fields' => ['Departments__name' => 'Departments.name']]]])
    ->column('Departments.name', ['label' => 'Department']);
```

In the template, reference the field `name` like:

```php
<?php
foreach ($results as $result)
{
    $this->DataTables->prepareData([
        $result->id,
        $result->department->name,
        $result->created,
        $result->modified,
        $this->Html->link('Edit', ['action' => 'edit', $result->id])
    ]);
}
echo $this->DataTables->response();
```

**2** - Complex : Adding contextual conditions with where

Now you have a datatable to list the objects of the current user. This is not easy, because the html and the ajax call are separated. How can you pass the parameter to the ajax ? As explained in the issue #6, a solution was to write the value in session when displaying the HTML part, and retrieve it where sending back the JSON part. It could lead to some issues, if you open two tabs in the browser and refreshing the datatables via some javascript (for example after adding an element).

A better solution is to parse the id from the referer. Let's say the URL for the list of user's objects is something like `/users/objects/1` ; when you call the AJAX via `/users/get-data-tables-content/Objects?draw=...`, this URL is in the referer.

So in the `initialize()` method of the controller:

```php
$elts = preg_split('/\//', $this->referer());
$user_id = array_pop($elts);
```

Use this value in a `where` clause :

```php
$this->DataTables->createConfig('UserObjects')
  ->queryOptions([
      'conditions' => ['user_id' => $user_id],
  ])
```

## Other configurations options

**1** - In `return` of `$this->DataTables->createConfig('ListPhones'))` method you can call


- `->column($name, array $options = [])` - Set up a new column in the table;
- `->databaseColumn($name)` - Inserts a database column in the SQL search result that can be used in ajax view;
- `->options(array $options = [])` - Used to setup [DataTables] library settings;
- `->table($name)` - Use a database table different from the configuration name;
- `->queryOptions(array $options = [])` - Used to make all the possible configurations in the SQL search that you would do in `find('type', '$options')`;
- `->finder($finder)` - Used to change the finder type from query in `find('type')`. 


**2** - In the column `->column('column_name', $options = [])` you can use this `$options`
- `*className` - Class(es) to add in `th` column tag. **default:** `null`;
- `*cellType` - Tag type of each column items. **default:** `'td'`;
- `*contentPadding` - Column padding. **default:** `null`;
- `database` - If `true` the **'column_name'** refers to a database column, otherwise, it is just a column that can be populated with any data. **default:** `true`;
- `*defaultContent` - The content for when a column element is empty. **default:** `null`;
- `label` - Name to show on table head. **default:** `column_name`;
- `*name` - Technical column name. **default:** `column_name`;
- `order` - Must be passed `asc` or `desc`. If this is configured for more than one column, it will sort by the order in which the columns were registered in the Component. If you want to choose which column to order first use `'order' => ['index' => -1, 'dir' => 'asc']` by passing a numerical for index to say which one should be sorted first.;
- `*orderable` - If `true`, the column can be sorted. **default:** `true`;
- `*orderDataType` - Sort type that DataTables will do. **default:** `'dom-text'`;
- `*searchable` - If `true`, the column will be included in the table search. **default:** `true`;
- `*type` - Sub-option of the `orderDataType` option. **default:** `'text'`;
- `*visible` - If `true`, the column will be visible. **default:** `true`;
- `*width` - Width of the column. If `null`, it is calculated automatically. **default:** `null`;

**Note:** `*` items are options from [DataTables] jQuery Library. To learn more read your documentation.

  
License
----

MIT



   [DataTables library]: <https://datatables.net/download/index>
   [DataTables]: <https://datatables.net/>
   [Composer]: <https://getcomposer.org/download/>
   [CakePHP 3.7]: <https://book.cakephp.org/3.0/en/installation.html>
   [Allan Carvalho]: <https://www.facebook.com/allanmcarvalho>
   
