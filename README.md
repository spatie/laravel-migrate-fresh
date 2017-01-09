# An artisan command to build up the database from scratch

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-migrate-fresh.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-migrate-fresh)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-migrate-fresh/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-migrate-fresh)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/b38ed189-9b84-455f-90ad-d8388d243274.svg?style=flat-square)](https://insight.sensiolabs.com/projects/b38ed189-9b84-455f-90ad-d8388d243274)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-migrate-fresh.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-migrate-fresh)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-migrate-fresh.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-migrate-fresh)

Laravel has a `migrate:refresh` command to build up the database using migrations. To clear the database it'll first rollback all migrations by using the `down` method in each migration.

But what if you don't use the `down` method inside your projects. Your migrations will fail as the database isn't cleared first.

This package contains a `migrate:fresh` command that'll nuke all the tables in your database regardless of whether you've set up the `down` method in each migration.

 ## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-migrate-fresh
```

Next add the `Spatie\MigrateFresh\Commands\MigrateFresh` class to your console kernel.

```php
// app/Console/Kernel.php

protected $commands = [
   ...
    \Spatie\MigrateFresh\Commands\MigrateFresh::class,
]
```

## Usage

Issueing this command will drop all tables from your database and run all migrations.

```bash
php artisan migrate:fresh
```

By tagging on the `seed` option all seeders will run as well.
 
```bash
php artisan migrate:fresh --seed
```

If the command is being executed in a production environment, confirmation will be asked first. To suppress the confirmation use the `force` option.
 
 ```bash
 php artisan migrate:fresh --force
 ```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
