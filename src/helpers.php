<?php

declare(strict_types=1);

use Bakame\Laravel\Intl\IntlExtension;
use Illuminate\Support\Facades\App;

if (! function_exists('country_name')) {
    function country_name(?string $country, string $locale = null): string
    {
        return IntlExtension::getCountryName($country, $locale ?? App::currentLocale());
    }
}

if (! function_exists('currency_name')) {
    function currency_name(?string $currency, string $locale = null): string
    {
        return IntlExtension::getCurrencyName($currency, $locale ?? App::currentLocale());
    }
}

if (! function_exists('currency_symbol')) {
    function currency_symbol(?string $currency, string $locale = null): string
    {
        return IntlExtension::getCurrencySymbol($currency, $locale ?? App::currentLocale());
    }
}

if (! function_exists('language_name')) {
    function language_name(?string $language, string $locale = null): string
    {
        return IntlExtension::getLanguageName($language, $locale ?? App::currentLocale());
    }
}

if (! function_exists('locale_name')) {
    function locale_name(?string $data, string $locale = null): string
    {
        return IntlExtension::getLocaleName($data, $locale ?? App::currentLocale());
    }
}

if (! function_exists('timezone_name')) {
    function timezone_name(?string $timezone, string $locale = null): string
    {
        return IntlExtension::getTimezoneName($timezone, $locale ?? App::currentLocale());
    }
}

if (! function_exists('country_timezones')) {
    /**
     * @return array<string>
     */
    function country_timezones(string $country): array
    {
        return IntlExtension::getCountryTimezones($country);
    }
}

if (! function_exists('format_currency')) {
    /**
     * @param int|string               $amount
     * @param array<string, int|float> $attrs
     */
    function format_currency(
        $amount,
        string $currency,
        array $attrs = [],
        string $locale = null
    ): string {
        return IntlExtension::formatCurrency($amount, $currency, $attrs, $locale ?? App::currentLocale());
    }
}

if (! function_exists('format_number')) {
    /**
     * @param int|string               $number
     * @param array<string, int|float> $attrs
     */
    function format_number(
        $number,
        array $attrs = [],
        string $style = 'decimal',
        string $type = 'default',
        string $locale = null
    ): string {
        return IntlExtension::formatNumber($number, $attrs, $style, $type, $locale ?? App::currentLocale());
    }
}
