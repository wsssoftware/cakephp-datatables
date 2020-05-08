Baking DataTables Classes
#########################

The plugin provide the bake command to create the `DataTables` class files that you will need to create and customize
your table. As default the class name will be the same as database table name, but you can change this passing the
option `--table` in command to inform what is the table name used in that DataTables class.

If the table and the class have the same name you must enter::

    cake bake data_tables config Categories

Where in sample `Categories` is the database table name. This will result in a `CategoriesDataTables` file that will be
saved on ``src/DataTables/CategoriesDataTables.php`` and it datasource is the `categories` table.

If you want want use a different table you must enter::

    cake bake data_tables config MyCategories --table=Categories

Where in sample `MyCategories` is the html table name. This will result in a `MyCategoriesDataTables` file that will be
saved on ``src/DataTables/MyCategoriesDataTables.php`` and it datasource is the `categories` table. Inside the class you
will see a attribute that will tell the plugin that it have a different database table name from class name::

    /**
     * Class MyCategoriesDataTables
     */
    class MyCategoriesDataTables extends DataTables {


    protected $_ormTableName = 'Categories';