# CakePHP DataTables Plugin Documentation - [(Back)](README.md)


## Installation
#### 1. Load the plugin using composer.
```shell
composer require wsssoftware/cakephp-datatables:^2.0
```

#### 2. Loading the plugin in your application.
In `src/Application.php`'s bootstrap() using:
```php
$this->addPlugin('DataTables');
//OR
$this->addPlugin(\DataTables\Plugin::class);
```
OR using cake shell in `bin folder`:
```shell
cake plugin load DataTables
```

#### 3. Loading DataTables helper.
In `src/View/AppView.php`'s initialize() using:
```php
$this->loadHelper('DataTables.DataTables');
```
#### 4. Setting the script renderer.
In `templates/layout/default.php`:
```html
    ...

    <?= $this->fetch('css') ?>
</head>

    ...

    <?= $this->fetch('script') ?>
    <?= $this->DataTables->renderJs() ?>
</body>
</html>
```
> You will need fetch `css` and `script` if you are using the DataTables plugin resources autoload. If you intent load manually the files, you can skip fetch. The `renderJs()` must stay at bottom of `fetch('script')`.

