<?php

declare(strict_types=1);

use Bakame\Laravel\Intl\FormatterFacade;
use Illuminate\Support\Facades\App;

if (! function_exists('country_name')) {
    function country_name(?string $country, string $locale = null): string
    {
        return FormatterFacade::getCountryName($country, $locale ?? App::currentLocale());
    }
}

if (! function_exists('currency_name')) {
    function currency_name(?string $currency, string $locale = null): string
    {
        return FormatterFacade::getCurrencyName($currency, $locale ?? App::currentLocale());
    }
}

if (! function_exists('currency_symbol')) {
    function currency_symbol(?string $currency, string $locale = null): string
    {
        return FormatterFacade::getCurrencySymbol($currency, $locale ?? App::currentLocale());
    }
}

if (! function_exists('language_name')) {
    function language_name(?string $language, string $locale = null): string
    {
        return FormatterFacade::getLanguageName($language, $locale ?? App::currentLocale());
    }
}

if (! function_exists('locale_name')) {
    function locale_name(?string $data, string $locale = null): string
    {
        return FormatterFacade::getLocaleName($data, $locale ?? App::currentLocale());
    }
}

if (! function_exists('timezone_name')) {
    function timezone_name(?string $timezone, string $locale = null): string
    {
        return FormatterFacade::getTimezoneName($timezone, $locale ?? App::currentLocale());
    }
}

if (! function_exists('country_timezones')) {
    /**
     * @return array<string>
     */
    function country_timezones(string $country): array
    {
        return FormatterFacade::getCountryTimezones($country);
    }
}

if (! function_exists('format_currency')) {
    /**
     * @param int|float                $amount
     * @param array<string, int|float> $attrs
     */
    function format_currency(
        $amount,
        string $currency,
        array $attrs = [],
        string $locale = null
    ): string {
        return FormatterFacade::formatCurrency($amount, $currency, $attrs, $locale ?? App::currentLocale());
    }
}

if (! function_exists('format_number')) {
    /**
     * @param int|float                $number
     * @param array<string, int|float> $attrs
     */
    function format_number(
        $number,
        array $attrs = [],
        string $style = 'decimal',
        string $type = 'default',
        string $locale = null
    ): string {
        return FormatterFacade::formatNumber($number, $attrs, $style, $type, $locale ?? App::currentLocale());
    }
}

if (! function_exists('format_datetime')) {
    /**
     * @param DateTimeInterface|string|null  $date     A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    function format_datetime(
        $date,
        ?string $dateFormat = 'medium',
        ?string $timeFormat = 'medium',
        ?string $pattern = '',
        $timezone = null,
        string $calendar = 'gregorian',
        string $locale = null
    ): string {
        return FormatterFacade::formatDateTime(
            $date,
            $dateFormat,
            $timeFormat,
            $pattern,
            $timezone,
            $calendar,
            $locale ?? App::currentLocale()
        );
    }
}

if (! function_exists('format_date')) {
    /**
     * @param DateTimeInterface|string|null  $date     A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    function format_date(
        $date,
        ?string $dateFormat = 'medium',
        ?string $pattern = '',
        $timezone = null,
        string $calendar = 'gregorian',
        string $locale = null
    ): string {
        return FormatterFacade::formatDate(
            $date,
            $dateFormat,
            $pattern,
            $timezone,
            $calendar,
            $locale ?? App::currentLocale()
        );
    }
}

if (! function_exists('format_time')) {
    /**
     * @param DateTimeInterface|string|null  $date     A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    function format_time(
        $date,
        ?string $timeFormat = 'medium',
        ?string $pattern = '',
        $timezone = null,
        string $calendar = 'gregorian',
        string $locale = null
    ): string {
        return FormatterFacade::formatTime(
            $date,
            $timeFormat,
            $pattern,
            $timezone,
            $calendar,
            $locale ?? App::currentLocale()
        );
    }
}