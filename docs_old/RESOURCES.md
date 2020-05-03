# DataTables resources - [(Back)](README.md)

## Customizing files and themes to load.

> By default, the autoload will load only DataTables css and js files, but you can change this and select your theme, jQuery and plugins.

```php
/**
 * Initialization hook method.
 *
 * Use this method to add common initialization code like loading components.
 *
 * e.g. `$this->loadComponent('FormProtection');`
 *
 * @return void
 */
public function initialize(): void {
    // in AppController
    LocalResourcesConfig::getInstance()
        ->setTheme(LocalResourcesConfig::THEME_BASE)
        ->setJquery(LocalResourcesConfig::JQUERY_3);

}
```  


