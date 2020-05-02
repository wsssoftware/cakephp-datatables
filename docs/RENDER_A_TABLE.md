# Render a table - [(Back)](README.md)

## Adding some DataTables options.

```html
<!-- Inside a view file -->
<?= $this->DataTables->renderTable('Categories') ?>
<!-- or -->
<?= $this->DataTables->renderTable(\App\DataTables\CategoriesDataTables::class) ?>
``` 