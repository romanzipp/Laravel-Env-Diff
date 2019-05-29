# Laravel Env Diff

[![Latest Stable Version](https://img.shields.io/packagist/v/romanzipp/laravel-env-diff.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![Total Downloads](https://img.shields.io/packagist/dt/romanzipp/laravel-env-diff.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![License](https://img.shields.io/packagist/l/romanzipp/laravel-env-diff.svg?style=flat-square)](https://packagist.org/packages/romanzipp/laravel-env-diff)

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
    /**
     * Additional .env files which will be compared to the example
     * entries, like .env.test
     */
    'additional_files' => [],

    /**
     * Check and warn for variables that exist in .env but not in
     * .env.example files
     */
    'reverse_example_check' => true,
];
```

## Usage

```
$ php artisan diff:env
```

![Preview](https://raw.githubusercontent.com/romanzipp/Laravel-Env-Diff/master/preview.png)
