# Baking files - [(Back)](README.md)

## Baking a DataTables class.
```shell
cake bake data_tables config Categories
```
or
```shell
cake bake data_tables config Categories --table=Users
```

> This will bake a `CategoriesDatatables` in `src/DataTables`. In this class you can configure all business rule of table.

## Baking a DataTables callback.
```shell
cake bake data_tables callback Categories created_cell
```

> This will bake a callback file `templates/data_table/Categories/callback/created_cell.js` that is the body of DataTables JS function. The plugin will get this body and put on callback function.
> Is used the twig to render, so you can pass some vars to it. More info about how to use it, on setup tables options.