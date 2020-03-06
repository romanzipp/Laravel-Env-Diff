# Laravel Env Diff

[![Latest Stable Version](https://img.shields.io/packagist/v/romanzipp/laravel-env-diff.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![Total Downloads](https://img.shields.io/packagist/dt/romanzipp/laravel-env-diff.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![License](https://img.shields.io/packagist/l/romanzipp/laravel-env-diff.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![Travis Build Status](https://img.shields.io/travis/romanzipp/Laravel-Env-Diff/master.svg?style=flat-square)](https://travis-ci.org/romanzipp/Laravel-Env-Diff)

Create a visual Diff of .env and .env.example files

## Installation

```
composer require romanzipp/laravel-env-diff
```

**If you use Laravel 5.5+ you are already done, otherwise continue.**

Add Service Provider to your `app.php` configuration file:

```php
romanzipp\EnvDiff\Providers\EnvDiffProvider::class,
```

## Configuration

Copy configuration to config folder:

```
$ php artisan vendor:publish --provider="romanzipp\EnvDiff\Providers\EnvDiffProvider"
```

```php
return [
    /*
     * Specify all environment files that should be compared.
     */
    'files'         => [
        '.env',
        '.env.example',
    ],

    /*
     * The base path to look for environment files.
     */
    'path'          => app_path(),

    /*
     * User colors when printing console output.
     */
    'use_colors'    => true,

    /*
     * Hide variables that exist in all .env files.
     */
    'hide_existing' => true,

    /*
     * Show existing env values instead of y/n.
     */
    'show_values'   => false,
];
```

## Usage

```
$ php artisan env:diff
              {files? : Specify environment files, overriding config}
              {--values : Display existing environment values}';
```

## Example

```
$ php artisan env:diff .env,.env.second
```

![Preview](https://raw.githubusercontent.com/romanzipp/Laravel-Env-Diff/master/preview-default.png)

```
$ php artisan env:diff .env,.env.second --values
```

![Preview](https://raw.githubusercontent.com/romanzipp/Laravel-Env-Diff/master/preview-values.png)

## Testing

```shell
./vendor/bin/phpunit
```
