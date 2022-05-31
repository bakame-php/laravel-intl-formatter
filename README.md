Laravel Intl Extra
=======================================

[![Author](http://img.shields.io/badge/author-@nyamsprod-blue.svg?style=flat-square)](https://twitter.com/nyamsprod)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://github.com/bakame-php/http-structured-fields/workflows/build/badge.svg)](https://github.com/bakame-php/http-structured-fields/actions?query=workflow%3A%22build%22)
[![Latest Version](https://img.shields.io/github/release/bakame-php/http-structured-fields.svg?style=flat-square)](https://github.com/bakame-php/http-structured-fields/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/bakame/http-structured-fields.svg?style=flat-square)](https://packagist.org/packages/bakame/http-structured-fields)
[![Sponsor development of this project](https://img.shields.io/badge/sponsor%20this%20package-%E2%9D%A4-ff69b4.svg?style=flat-square)](https://github.com/sponsors/nyamsprod)

This is a Laravel centric port of the [Twig Intl Extension](https://github.com/twigphp/intl-extra) package.

The package can be used in any Laravel based application to quickly handle 
internationalization by providing a Laravel Facade to the `IntlExtension`. 

It is also possible to use the package outside of blade templates if needed.

System Requirements
-------

- Laravel 8 and 9 and the same requirement as its [parent package](https://github.com/twigphp/intl-extra)

Installation
------------

Use composer:

```
composer require bakame/laravel-intl-extra
```

Documentation
------------

Once installed the package provides a Facade to `Twig\Extra\Intl\IntlExtension` as `Bakame\Laravel\Intl\IntlExtension` 
to use in your Laravel based application or in blade templtes as shown below.

```blade
country name: {{ Bakame\Laravel\Intl\IntlExtension::getCountryName($country, $locale) }}
```

```php
$content = view($templatePath, ['country' => 'FR', 'locale' => 'NL])->render();
echo $content, PHP_EOL; // country name: Frankrijk
```

Full documentation can be found on [Twig Intl Extension](https://github.com/twigphp/intl-extra) package


Contributing
-------

Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CODE OF CONDUCT](.github/CODE_OF_CONDUCT.md) for details.

Testing
-------

The library:

- has a [PHPUnit](https://phpunit.de) test suite
- has a coding style compliance test suite using [PHP CS Fixer](https://cs.sensiolabs.org/).
- has a code analysis compliance test suite using [PHPStan](https://github.com/phpstan/phpstan).
- is compliant with [the language agnostic HTTP Structured Fields Test suite](https://github.com/httpwg/structured-field-tests).

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
- [All Contributors](https://github.com/bakame-php/http-structured-fields/contributors)

Attribution
-------

The package internal parser is heavily inspired by previous work done by [Gapple](https://twitter.com/gappleca) on [Structured Field Values for PHP](https://github.com/gapple/structured-fields/).

License
-------

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[1]: https://www.rfc-editor.org/rfc/rfc8941.html
[2]: https://www.ietf.org/id/draft-ietf-httpbis-retrofit-00.html
[3]: https://www.rfc-editor.org/rfc/rfc8941.html#section-3.3
[4]: https://www.php-fig.org/psr/psr-4/
