<?php

declare(strict_types=1);

use Bakame\Intl\Laravel\IntlFormatter;
use Illuminate\Support\Facades\App;

if (! function_exists('country_name')) {
    function country_name(?string $country, string $locale = null): string
    {
        return IntlFormatter::getCountryName($country, $locale ?? App::currentLocale());
    }
}

if (! function_exists('currency_name')) {
    function currency_name(?string $currency, string $locale = null): string
    {
        return IntlFormatter::getCurrencyName($currency, $locale ?? App::currentLocale());
    }
}

if (! function_exists('currency_symbol')) {
    function currency_symbol(?string $currency, string $locale = null): string
    {
        return IntlFormatter::getCurrencySymbol($currency, $locale ?? App::currentLocale());
    }
}

if (! function_exists('language_name')) {
    function language_name(?string $language, string $locale = null): string
    {
        return IntlFormatter::getLanguageName($language, $locale ?? App::currentLocale());
    }
}

if (! function_exists('locale_name')) {
    function locale_name(?string $data, string $locale = null): string
    {
        return IntlFormatter::getLocaleName($data, $locale ?? App::currentLocale());
    }
}

if (! function_exists('timezone_name')) {
    function timezone_name(?string $timezone, string $locale = null): string
    {
        return IntlFormatter::getTimezoneName($timezone, $locale ?? App::currentLocale());
    }
}

if (! function_exists('country_timezones')) {
    /**
     * @return array<string>
     */
    function country_timezones(string $country): array
    {
        return IntlFormatter::getCountryTimezones($country);
    }
}

if (! function_exists('format_currency')) {
    /**
     * @param int|float $amount
     * @param array<string, int|float> $attrs
     */
    function format_currency(
        $amount,
        string $currency,
        ?string $locale = null,
        array $attrs = []
    ): string {
        return IntlFormatter::formatCurrency($amount, $currency, $locale ?? App::currentLocale(), $attrs);
    }
}

if (! function_exists('format_number')) {
    /**
     * @param int|float $number
     * @param array<string, int|float> $attrs
     */
    function format_number(
        $number,
        ?string $locale = null,
        string $type = 'default',
        array $attrs = [],
        ?string $style = null
    ): string {
        return IntlFormatter::formatNumber($number, $locale ?? App::currentLocale(), $type, $attrs, $style);
    }
}

if (! function_exists('format_datetime')) {
    /**
     * @param DateTimeInterface|string|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    function format_datetime(
        $date,
        ?string $locale = null,
        $timezone = null,
        ?string $dateFormat = null,
        ?string $timeFormat = null,
        ?string $pattern = null,
        ?string $calendar = null
    ): string {
        return IntlFormatter::formatDateTime(
            $date,
            $locale ?? App::currentLocale(),
            $timezone,
            $dateFormat,
            $timeFormat,
            $pattern,
            $calendar
        );
    }
}

if (! function_exists('format_date')) {
    /**
     * @param DateTimeInterface|string|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    function format_date(
        $date,
        ?string $locale = null,
        $timezone = null,
        ?string $dateFormat = null,
        ?string $pattern = null,
        ?string $calendar = null
    ): string {
        return IntlFormatter::formatDate(
            $date,
            $locale ?? App::currentLocale(),
            $timezone,
            $dateFormat,
            $pattern,
            $calendar
        );
    }
}

if (! function_exists('format_time')) {
    /**
     * @param DateTimeInterface|string|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    function format_time(
        $date,
        ?string $locale = null,
        $timezone = null,
        ?string $timeFormat = null,
        ?string $pattern = null,
        ?string $calendar = null
    ): string {
        return IntlFormatter::formatTime(
            $date,
            $locale ?? App::currentLocale(),
            $timezone,
            $timeFormat,
            $pattern,
            $calendar
        );
    }
}
