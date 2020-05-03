# Columns - [(Back)](README.md)

## Adding some columns and configurations for it.

```php
/**
 * @param \DataTables\Table\ConfigBundle $configBundle
 * @return void
 */
public function config(ConfigBundle $configBundle): void {

    ...

    $configBundle->Columns->addDatabaseColumn('Categories.id')
        ->setTitle('Code');
    $configBundle->Columns->addDatabaseColumn('Categories.name');
    $configBundle->Columns->addDatabaseColumn('Categories.status');
    $configBundle->Columns->addDatabaseColumn('Categories.created');
    $configBundle->Columns->addDatabaseColumn('Categories.modified')
        ->setSearchable(false)
        ->setOrderable(false);
    $configBundle->Columns->addNonDatabaseColumn('action');

    ...

}
```

> Column object that is the return of a column create have all possible configuration of section [Columns](https://datatables.net/reference/option/) in DataTables site. 
