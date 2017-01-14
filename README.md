# DataTables plugin for CakePHP 3.x



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
* [CakePHP 3.x] - Recommended always use the latest available version;


### Installation

There are two recommended ways to install this plugin:

**1** - Using `composer.json`
```javascript
"require": {
    "allanmcarvalho/datatables": "1.*"
}
```

**2** - Using `prompt`

```sh
$ php composer.phar require allanmcarvalho/datatables
```


### Basic configuration

**1** - In `bootstrap.php` load the plugin
```php
Plugin::load('DataTables');
```

**2** - In the `ExampleController.php` that you will use DataTables use the `DataTablesAjaxRequestTrait` and load `DataTablesComponent`
```php
...
class ExampleController extends AppController
{
    use DataTablesAjaxRequestTrait;
     public function initialize()
    {
        parent::initialize();
        $this->loadComponent('DataTables.DataTables');
    }
```
**Note:** `Trait` is required in controller that you will use DataTables because it implements the ajax `action` that returns the data to the table.

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

**4** - Setting the `ajax` response view in `Template/{Controller}/json/datatables/user_statuses.ctp`

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

## Other configurations options

**1** - In `return` of `$this->DataTables->createConfig('ListPhones'))` method you can call


- `->column($name, array $options = [])` - Set up a new column in the table;
- `->databaseColumn($name)` - Inserts a database column in the SQL search result that can be used in ajax view;
- `->options(array $options = [])` - Used to setup [DataTables] library settings;
- `->table($name)` - Use a database table different from the configuration name;
- `->queryOptions(array $options = [])` - Used to make all the possible configurations in the SQL search that you would do in `find('type', '$options')`


**2** - In the column `->column('column_name', $options = [])` you can use this `$options`
- `*className` - Class(es) to add in `th` column tag. **default:** `null`;
- `*cellType` - Tag type of each column items. **default:** `'td'`;
- `*contentPadding` - Column padding. **default:** `null`;
- `database` - If `true` the **'column_name'** refers to a database column, otherwise, it is just a column that can be populated with any data. **default:** `true`;
- `*defaultContent` - The content for when a column element is empty. **default:** `null`;
- `label` - Name to show on table head. **default:** `column_name`;
- `*name` - Technical column name. **default:** `column_name`;
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
   [CakePHP 3.x]: <https://book.cakephp.org/3.0/en/installation.html>
   [Allan Carvalho]: <https://www.facebook.com/Allan.Mariucci.Carvalho>
   
