# Query - [(Back)](README.md)

## Adding some DataTables options.

```php
/**
 * @param \DataTables\Table\ConfigBundle $configBundle
 * @return void
 */
public function config(ConfigBundle $configBundle): void {

    ...

    $configBundle->Query->where(['Categories.id >=' => 2]);

    ...

}
```

> Query options have almost all `where` clauses of CakePHP Query class.  


