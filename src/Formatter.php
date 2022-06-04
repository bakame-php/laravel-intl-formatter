<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Bakame\Laravel\Intl\Options\DateType;
use Bakame\Laravel\Intl\Options\NumberAttribute;
use Bakame\Laravel\Intl\Options\NumberStyle;
use Bakame\Laravel\Intl\Options\NumberType;
use Bakame\Laravel\Intl\Options\TimeType;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use IntlDateFormatter;
use Locale;
use NumberFormatter;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Currencies;
use Symfony\Component\Intl\Exception\MissingResourceException;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Locales;
use Symfony\Component\Intl\Timezones;

final class Formatter
{
    private Configuration $configuration;
    private DateResolver $dateResolver;
    /** @var array<IntlDateFormatter> */
    private array $dateFormatters = [];
    /** @var array<NumberFormatter> */
    private array $numberFormatters = [];

    public function __construct(Configuration $configuration, DateResolver $dateResolver)
    {
        $this->configuration = $configuration;
        $this->dateResolver = $dateResolver;
    }

    public function getCountryName(?string $country, string $locale = null): string
    {
        if (null === $country) {
            return '';
        }

        try {
            return Countries::getName($country, $locale);
        } catch (MissingResourceException $exception) {
            return $country;
        }
    }

    public function getCurrencyName(?string $currency, string $locale = null): string
    {
        if (null === $currency) {
            return '';
        }

        try {
            return Currencies::getName($currency, $locale);
        } catch (MissingResourceException $exception) {
            return $currency;
        }
    }

    public function getCurrencySymbol(?string $currency, string $locale = null): string
    {
        if (null === $currency) {
            return '';
        }

        try {
            return Currencies::getSymbol($currency, $locale);
        } catch (MissingResourceException $exception) {
            return $currency;
        }
    }

    public function getLanguageName(?string $language, string $locale = null): string
    {
        if (null === $language) {
            return '';
        }

        try {
            return Languages::getName($language, $locale);
        } catch (MissingResourceException $exception) {
            return $language;
        }
    }

    public function getLocaleName(?string $data, string $locale = null): string
    {
        if (null === $data) {
            return '';
        }

        try {
            return Locales::getName($data, $locale);
        } catch (MissingResourceException $exception) {
            return $data;
        }
    }

    public function getTimezoneName(?string $timezone, string $locale = null): string
    {
        if (null === $timezone) {
            return '';
        }

        try {
            return Timezones::getName($timezone, $locale);
        } catch (MissingResourceException $exception) {
            return $timezone;
        }
    }

    /**
     * @return array<string>
     */
    public function getCountryTimezones(string $country): array
    {
        try {
            return Timezones::forCountryCode($country);
        } catch (MissingResourceException $exception) {
            return [];
        }
    }

    /**
     * @param int|float $amount
     * @param array<string, int|float|string> $attrs
     */
    public function formatCurrency($amount, string $currency, array $attrs = [], string $locale = null): string
    {
        $formatter = $this->createNumberFormatter($locale, NumberStyle::fromName('currency'), $attrs);
        if (false === $ret = $formatter->formatCurrency($amount, $currency)) {
            // @codeCoverageIgnoreStart
            throw FailedFormatting::dueToNumberFormatter('Unable to format the given number as a currency.');
            // @codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * @param int|float $number
     * @param array<string, int|float|string> $attrs
     */
    public function formatNumber(
        $number,
        array $attrs = [],
        ?string $style = null,
        string $type = 'default',
        string $locale = null
    ): string {
        $style = null === $style ? $this->configuration->style : NumberStyle::fromName($style);
        $formatter = $this->createNumberFormatter($locale, $style, $attrs);
        if (false === $ret = $formatter->format($number, NumberType::fromName($type)->value)) {
            // @codeCoverageIgnoreStart
            throw FailedFormatting::dueToNumberFormatter('Unable to format the given number.');
            // @codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * @param DateTimeInterface|string|int|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     *
     * @throws FailedFormatting
     */
    public function formatDateTime(
        $date,
        ?string $dateFormat = null,
        ?string $timeFormat = null,
        ?string $pattern = null,
        $timezone = null,
        string $calendar = 'gregorian',
        string $locale = null
    ): string {
        try {
            $date = $this->dateResolver->resolve($date, $timezone);
        } catch (Exception $exception) {
            throw FailedFormatting::dueToInvalidDate($exception);
        }

        $formatter = $this->createDateFormatter($locale, $dateFormat, $timeFormat, $pattern, $date->getTimezone(), $calendar);
        if (false === $ret = $formatter->format($date)) {
            // @codeCoverageIgnoreStart
            throw FailedFormatting::dueToDateFormatter('Unable to format the given date.');
            // @codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * @param DateTimeInterface|string|int|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    public function formatDate(
        $date,
        ?string $dateFormat = null,
        ?string $pattern = null,
        $timezone = null,
        string $calendar = 'gregorian',
        string $locale = null
    ): string {
        return $this->formatDateTime($date, $dateFormat, 'none', $pattern, $timezone, $calendar, $locale);
    }

    /**
     * @param DateTimeInterface|string|int|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    public function formatTime(
        $date,
        ?string $timeFormat = null,
        ?string $pattern = null,
        $timezone = null,
        string $calendar = 'gregorian',
        string $locale = null
    ): string {
        return $this->formatDateTime($date, 'none', $timeFormat, $pattern, $timezone, $calendar, $locale);
    }

    private function createDateFormatter(
        ?string $locale,
        ?string $dateFormat,
        ?string $timeFormat,
        ?string $pattern,
        DateTimeZone $timezone,
        string $calendar
    ): IntlDateFormatter {
        $dateType = null !== $dateFormat ? DateType::fromName($dateFormat) : $this->configuration->dateType;
        $timeType = null !== $timeFormat ? TimeType::fromName($timeFormat) : $this->configuration->timeType;
        $locale = $locale ?? Locale::getDefault();
        $calendar = 'gregorian' === strtolower($calendar) ? IntlDateFormatter::GREGORIAN : IntlDateFormatter::TRADITIONAL;
        $pattern = $pattern ?? $this->configuration->datePattern;

        $hash = $locale.'|'.$dateType->value.'|'.$timeType->value.'|'.$timezone->getName().'|'.$calendar.'|'.$pattern;
        if (!isset($this->dateFormatters[$hash])) {
            $dateFormatter = new IntlDateFormatter($locale, $dateType->value, $timeType->value, $timezone, $calendar);
            if (null !== $pattern) {
                $dateFormatter->setPattern($pattern);
            }
            $this->dateFormatters[$hash] = $dateFormatter;
        }

        return $this->dateFormatters[$hash];
    }

    /**
     * @param array<string, string|float|int> $attrs
     */
    private function createNumberFormatter(?string $locale, NumberStyle $style, array $attrs = []): NumberFormatter
    {
        $locale = $locale ?? Locale::getDefault();

        ksort($attrs);
        $hash = $locale.'|'.$style->value.'|'.json_encode($attrs);
        if (!isset($this->numberFormatters[$hash])) {
            $newNumberFormatter = new NumberFormatter($locale, $style->value);
            $this->addDefaultAttributes($newNumberFormatter);
            $this->setNumberFormatterAttributes($newNumberFormatter, $attrs);
            $this->numberFormatters[$hash] = $newNumberFormatter;
        }

        return $this->numberFormatters[$hash];
    }

    /**
     * @param array<string, string|int|float> $attrs
     */
    private function setNumberFormatterAttributes(NumberFormatter $numberFormatter, array $attrs): void
    {
        foreach ($attrs as $name => $value) {
            NumberAttribute::from($name, $value)->addTo($numberFormatter);
        }
    }

    private function addDefaultAttributes(NumberFormatter $numberFormatter): void
    {
        foreach ($this->configuration->attributes as $attribute => $value) {
            $numberFormatter->setAttribute($attribute, $value);
        }

        foreach ($this->configuration->textAttributes as $attribute => $value) {
            $numberFormatter->setTextAttribute($attribute, $value);
        }

        foreach ($this->configuration->symbolAttributes as $attribute => $value) {
            $numberFormatter->setSymbol($attribute, $value);
        }

        if (null !== $this->configuration->numberPattern) {
            $numberFormatter->setPattern($this->configuration->numberPattern);
        }
    }
}
