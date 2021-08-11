# H5P Plugin in Laravel Framework 

## Description


## Installation

Require it in the Composer.

```bash
composer require mohammed-zaki/laravel-h5p
```

Publish the Views, Config and so things.

```bash
php artisan vendor:publish --provider="Zaki\LaravelH5p\LaravelH5pServiceProvider"
```

Migrate the Database

```bash
php artisan migrate
```

Add to Composer-Classmap:
```php
'classmap': [
    "vendor/h5p/h5p-core/h5p-default-storage.class.php",
    "vendor/h5p/h5p-core/h5p-development.class.php",
    "vendor/h5p/h5p-core/h5p-event-base.class.php",
    "vendor/h5p/h5p-core/h5p-file-storage.interface.php",
    "vendor/h5p/h5p-core/h5p.classes.php",
    "vendor/h5p/h5p-editor/h5peditor-ajax.class.php",
    "vendor/h5p/h5p-editor/h5peditor-ajax.interface.php",
    "vendor/h5p/h5p-editor/h5peditor-file.class.php",
    "vendor/h5p/h5p-editor/h5peditor-storage.interface.php",
    "vendor/h5p/h5p-editor/h5peditor.class.php"
],
```

```php
'providers' => [
    Zaki\LaravelH5p\LaravelH5pServiceProvider::class,
];
```

For linux
```bash
cd public/vendor/h5p
ln -s ../../../storage/h5p/content
ln -s ../../../storage/h5p/editor
ln -s ../../../storage/h5p/libraries
```
For windows
```cmd admin window
cd public/vendor/h5p
mklink /d content ..\..\..\storage\h5p\content
mklink /d editor ..\..\..\storage\h5p\editor
mklink /d libraries ..\..\..\storage\h5p\libraries
```

## Credits

[Abdelouahab Djoudi](https://github.com/djoudi/Laravel-H5P) - Package creator.

[Anass Boutakaoua](https://github.com/soyamore/Laravel-H5P) - Laravel 7 support and base for this package.

[Escola Soft](https://github.com/EscolaSoft/Laravel-H5P) - EscolaSoft/Laravel-H5P base for this package 