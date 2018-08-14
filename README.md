# Laravel Env Diff

[![Latest Stable Version](https://poser.pugx.org/romanzipp/laravel-env-diff/version)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![Total Downloads](https://poser.pugx.org/romanzipp/laravel-env-diff/downloads)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![License](https://poser.pugx.org/romanzipp/laravel-env-diff/license)](https://packagist.org/packages/romanzipp/laravel-env-diff)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/romanzipp/Laravel-Queue-Monitor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/romanzipp/Laravel-Queue-Monitor/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/romanzipp/Laravel-Queue-Monitor/badges/build.png?b=master)](https://scrutinizer-ci.com/g/romanzipp/Laravel-Queue-Monitor/build-status/master)
[![StyleCI](https://styleci.io/repos/120360910/shield?branch=master&style=flat)](https://styleci.io/repos/120360910)

Create a visual Diff of .env and .env.example files

## Installation

```
composer require romanzipp/laravel-env-diff
```

Or add `romanzipp/laravel-env-diff` to your `composer.json`

```
"romanzipp/laravel-env-diff": "*"
```

Run composer update to pull the latest version.

**If you use Laravel 5.5+ you are already done, otherwise continue:**

```php
romanzipp\EnvDiff\Providers\QueueMonitorProvider::class,
```

Add Service Provider to your app.php configuration file:

## Configuration
