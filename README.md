Laravel Intl Formatter
=======================================

[![Author](http://img.shields.io/badge/author-@nyamsprod-blue.svg?style=flat-square)](https://twitter.com/nyamsprod)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://github.com/bakame-php/laravel-intl-extra/workflows/build/badge.svg)](https://github.com/bakame-php/laravel-intl-extra/actions?query=workflow%3A%22build%22)
[![Latest Version](https://img.shields.io/github/release/bakame-php/laravel-intl-extra.svg?style=flat-square)](https://github.com/bakame-php/laravel-intl-extra/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/bakame/laravel-intl-extra.svg?style=flat-square)](https://packagist.org/packages/bakame/laravel-intl-extra)
[![Sponsor development of this project](https://img.shields.io/badge/sponsor%20this%20package-%E2%9D%A4-ff69b4.svg?style=flat-square)](https://github.com/sponsors/nyamsprod)

This is a Laravel port of the [Twig Intl Extension](https://github.com/twigphp/intl-extra) package.

The package can be used in any Laravel based application to quickly handle internationalization 
by providing helper functions in Blade templates or Laravel codebase.

System Requirements
-------

- Laravel 8 and/or 9
- Symfony Intl component

Installation
------------

Use composer:

```
composer require bakame/laravel-intl-formatter
```

Configuration
------------

In order to edit the default configuration you need to publish the package configuration to your application config directory:

```bash
php artisan vendor:publish --provider="Bakame\Laravel\Intl" --tag=config
```

The configuration file will be published to `config/bakame-intl-formatter.php` in your application directory.

Please refer to the config file for an overview of the available options.

Documentation
------------

Once installed the package provides the following global helper functions:

### Country Name

Returns the country name given its two-letter/five-letter code;

```blade
country name: {{ country_name($country, $locale) }}
```

```php
echo view($templatePath, ['country' => 'FR', 'locale' => 'NL'])->render();
// country name: Frankrijk
```

### Currency Name

Returns the currency name given its three-letter code;

```blade
currency name: {{ currency_name($currency, $locale) }}
```

```php
echo view($templatePath, ['currency' => 'JPY', 'locale' => 'PT'])->render();
// currency name: Iene japonês
```

### Currency Symbol

Returns the currency symbol given its three-letter code;

```blade
currency symbol: {{ currency_symbol($currency, $locale) }}
```

```php
echo view($templatePath, ['currency' => 'JPY', 'locale' => 'PT'])->render();
// currency symbol: JP¥
```

### Language name

Returns the currency symbol given its three-letter code;

```blade
language name: {{ language_name($language, $locale) }}
```

```php
echo view($templatePath, ['language' => 'it', 'locale' => 'nl'])->render();
// language name: Italiaans
```

### Locale name

Returns the currency symbol given its three-letter code;

```blade
locale name: {{ locale_name($data, $locale) }}
```

```php
echo view($templatePath, ['data' => 'sw', 'locale' => 'nl'])->render();
// locale name: Swahili
```

### Timezone name

Returns the timezone name given its identifier;

```blade
timezone name: {{ locale_name($data, $locale) }}
```

```php
echo view($templatePath, ['timezone' => 'Asia/Tokyo', 'locale' => 'es'])->render();
// timezone name: hora de Japón (Tokio)
```

### Country Timezones

Returns the timezone identifiers of the given country code;

```blade
country timezones: {{ implde(", ", country_timezones($country)) }}
```

```php
$content = view($templatePath, ['country' => 'CD', 'locale' => 'es'])->render();
echo $content, PHP_EOL; // country timezones: Africa/Kinshasa, Africa/Lubumbashi
```

### Format Currency

Formats a number as a currency;

```blade
format currency: {{ format_currency($amount, $currency, $attrs, $locale) }}
```

```php
$templateData = [
    'amount' => 100.356, 
    'currency' => 'USD', 
    'locale' => 'ES', 
    'attrs' => [
        'fraction_digit' => 1,
        'rounding_mode' => 'floor',
    ]
];
echo view($templatePath, $templateData)->render();
// format currency: 100,3 US$
```

### Format Number

Formats a number;

```blade
format number: {{ format_number($number, $attrs, $locale) }}
```

```php
$templateData = [
    'number' => 100.356, 
    'locale' => 'nl', 
    'style' => 'spellout',
    'type' => 'double',
    'attrs' => [
        'fraction_digit' => 1,
        'rounding_mode' => 'floor',
    ]
];
echo view($templatePath, $templateData)->render();
// format number: honderd komma drie
```

### Format DateTime

Formats a date and time;

```blade
format datetime: {{ format_datetime($date, $dateFormat, $timeFormat, $pattern, $timezone, $calendar, $locale) }}
```

```php
$templateData = [
    'date' => 'yesterday', 
    'dateFormat' => 'full', 
    'timeFormat' => 'full', 
    'pattern' => '' ,
    'timezone' => 'Africa/Lubumbashi', 
    'calendar' => 'gregorian' ,
    'locale' => 'sw',
];
echo view($templatePath, $templateData)->render();
// format datetime: Alhamisi, 2 Juni 2022 00:00:00 Saa za Afrika ya Kati
```

### Format Date

Formats a the date portion of a datetime;

```blade
format date: {{ format_date($date, $dateFormat, $pattern, $timezone, $calendar, $locale) }}
```

```php
$templateData = [
    'date' => 'yesterday', 
    'dateFormat' => 'long', 
    'pattern' => '' ,
    'timezone' => 'Africa/Lubumbashi', 
    'calendar' => 'gregorian' ,
    'locale' => 'sw',
];
echo view($templatePath, $templateData)->render();
// format date: 2 Juni 2022
```

### Format Time

Formats the time portion of a datetime;

```blade
format time: {{ format_time($date, $timeFormat, $pattern, $timezone, $calendar, $locale) }}
```

```php
$templateData = [
    'date' => 'yesterday', 
    'dateFormat' => 'full', 
    'pattern' => '' ,
    'timezone' => 'Africa/Lubumbashi', 
    'calendar' => 'gregorian' ,
    'locale' => 'sw',
];
echo view($templatePath, $templateData)->render();
// format time: 00:00:00 Saa za Afrika ya Kati
```

Each function uses the same arguments in the same order as the Twig Extra package filters/functions.

### Locale specification 

If no `locale` is specified in function calls, the function will use the result of `Illuminate\Support\Facades\App::currentLocale()`
as the locale value to use.

### functions signature

In PHP8+, you can use named parameters to improve functions usages as they tend to have a lot of arguments:

**In PHP7.4**

```php 
<?php

echo format_datetime('2019-08-07 23:39:12', 'mediun', 'medium', '', null, 'gregorian', 'fr');
```

**In PHP8+**

```php 
<?php

echo format_datetime(date: '2019-08-07 23:39:12', locale: 'fr');
```

Contributing
-------

Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CODE OF CONDUCT](.github/CODE_OF_CONDUCT.md) for details.

Testing
-------

The library:

- has a [PHPUnit](https://phpunit.de) test suite
- has a coding style compliance test suite using [PHP CS Fixer](https://cs.sensiolabs.org/).
- has a code analysis compliance test suite using [PHPStan](https://github.com/phpstan/phpstan).

To run the tests, run the following command from the project folder.

``` bash
$ composer test
```

Security
-------

If you discover any security related issues, please email nyamsprod@gmail.com instead of using the issue tracker.

Credits
-------

- [ignace nyamagana butera](https://github.com/nyamsprod)
- [All Contributors](https://github.com/bakame-php/laravel-intl-extra/contributors)

Attribution
-------

The package `Formatter` class and the exposed functions are heavily inspired by previous works done by [Fabien Potencier](https://github.com/fabpot) on [Twig Intl Extension](https://github.com/twigphp/intl-extra).

License
-------

The MIT License (MIT). Please see [License File](LICENSE) for more information.
