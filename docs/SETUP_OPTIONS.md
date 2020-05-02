# Options - [(Back)](README.md)

## Adding some DataTables options.

```php
/**
 * @param \DataTables\Table\ConfigBundle $configBundle
 * @return void
 */
public function config(ConfigBundle $configBundle): void {

    ...

    $configBundle->Options
        ->setStateSave(true)
        ->setInfo(true)
        ->setSearchRegex(true)
        ->setLengthMenu([10, 25, 50, 75, 100]);

    ...

}
```

> Option object have almost all [configurations](https://datatables.net/reference/option/) of DataTables site. All methods have a good phpdoc and a link to a respective option in DataTables site that teach how pass the right param(s).  


