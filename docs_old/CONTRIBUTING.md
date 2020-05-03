# Contributing

I am looking forward to your contributions.

There are a few guidelines that I need contributors to follow:
* Coding standards (`composer cs-check` to check and `composer cs-fix` to fix)
* Passing tests (`php phpunit.phar`)



## Updating Locale POT file

Run this from your app dir to update the plugin's `datatables.pot` file:
```
bin/cake i18n extract --plugin DataTables --extract-core=no --merge=no --overwrite
```
