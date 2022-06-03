<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Illuminate\Support\Carbon;
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
    private const DATE_FORMATS = [
        'none' => IntlDateFormatter::NONE,
        'short' => IntlDateFormatter::SHORT,
        'medium' => IntlDateFormatter::MEDIUM,
        'long' => IntlDateFormatter::LONG,
        'full' => IntlDateFormatter::FULL,
    ];

    private const NUMBER_TYPES = [
        'default' => NumberFormatter::TYPE_DEFAULT,
        'int32' => NumberFormatter::TYPE_INT32,
        'int64' => NumberFormatter::TYPE_INT64,
        'double' => NumberFormatter::TYPE_DOUBLE,
        'currency' => NumberFormatter::TYPE_CURRENCY,
    ];

    private const NUMBER_STYLES = [
        'decimal' => NumberFormatter::DECIMAL,
        'currency' => NumberFormatter::CURRENCY,
        'percent' => NumberFormatter::PERCENT,
        'scientific' => NumberFormatter::SCIENTIFIC,
        'spellout' => NumberFormatter::SPELLOUT,
        'ordinal' => NumberFormatter::ORDINAL,
        'duration' => NumberFormatter::DURATION,
    ];

    private const NUMBER_ATTRIBUTES = [
        'grouping_used' => NumberFormatter::GROUPING_USED,
        'decimal_always_shown' => NumberFormatter::DECIMAL_ALWAYS_SHOWN,
        'max_integer_digit' => NumberFormatter::MAX_INTEGER_DIGITS,
        'min_integer_digit' => NumberFormatter::MIN_INTEGER_DIGITS,
        'integer_digit' => NumberFormatter::INTEGER_DIGITS,
        'max_fraction_digit' => NumberFormatter::MAX_FRACTION_DIGITS,
        'min_fraction_digit' => NumberFormatter::MIN_FRACTION_DIGITS,
        'fraction_digit' => NumberFormatter::FRACTION_DIGITS,
        'multiplier' => NumberFormatter::MULTIPLIER,
        'grouping_size' => NumberFormatter::GROUPING_SIZE,
        'rounding_mode' => NumberFormatter::ROUNDING_MODE,
        'rounding_increment' => NumberFormatter::ROUNDING_INCREMENT,
        'format_width' => NumberFormatter::FORMAT_WIDTH,
        'padding_position' => NumberFormatter::PADDING_POSITION,
        'secondary_grouping_size' => NumberFormatter::SECONDARY_GROUPING_SIZE,
        'significant_digits_used' => NumberFormatter::SIGNIFICANT_DIGITS_USED,
        'min_significant_digits_used' => NumberFormatter::MIN_SIGNIFICANT_DIGITS,
        'max_significant_digits_used' => NumberFormatter::MAX_SIGNIFICANT_DIGITS,
        'lenient_parse' => NumberFormatter::LENIENT_PARSE,
    ];

    private const NUMBER_ROUNDING_ATTRIBUTES = [
        'ceiling' => NumberFormatter::ROUND_CEILING,
        'floor' => NumberFormatter::ROUND_FLOOR,
        'down' => NumberFormatter::ROUND_DOWN,
        'up' => NumberFormatter::ROUND_UP,
        'halfeven' => NumberFormatter::ROUND_HALFEVEN,
        'halfdown' => NumberFormatter::ROUND_HALFDOWN,
        'halfup' => NumberFormatter::ROUND_HALFUP,
    ];

    private const NUMBER_PADDING_ATTRIBUTES = [
        'before_prefix' => NumberFormatter::PAD_BEFORE_PREFIX,
        'after_prefix' => NumberFormatter::PAD_AFTER_PREFIX,
        'before_suffix' => NumberFormatter::PAD_BEFORE_SUFFIX,
        'after_suffix' => NumberFormatter::PAD_AFTER_SUFFIX,
    ];

    private IntlDateFormatter $dateFormatterPrototype;
    private Configuration $configuration;
    /** @var array<IntlDateFormatter> */
    private array $dateFormatters = [];
    /** @var array<NumberFormatter> */
    private array $numberFormatters = [];

    public function __construct(IntlDateFormatter $dateFormatterPrototype, Configuration $configuration)
    {
        $this->dateFormatterPrototype = $dateFormatterPrototype;
        $this->configuration = $configuration;
    }

    public static function fromConfiguration(Configuration $configuration): self
    {
        return new self(
            new IntlDateFormatter(
                Locale::getDefault(),
                $configuration->dateType,
                $configuration->timeType,
                null,
                null,
                $configuration->datePattern
            ),
            $configuration
        );
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
        $formatter = $this->createNumberFormatter($locale, 'currency', $attrs);

        if (false === $ret = $formatter->formatCurrency($amount, $currency)) {
            throw new FailedFormatting('Unable to format the given number as a currency.');
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
        string $style = 'decimal',
        string $type = 'default',
        string $locale = null
    ): string {
        if (!isset(self::NUMBER_TYPES[$type])) {
            throw new FailedFormatting(sprintf('The type "%s" does not exist, known types are: "%s".', $type, implode('", "', array_keys(self::NUMBER_TYPES))));
        }

        $formatter = $this->createNumberFormatter($locale, $style, $attrs);
        if (false === $ret = $formatter->format($number, self::NUMBER_TYPES[$type])) {
            throw new FailedFormatting('Unable to format the given number.');
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
        ?string $dateFormat = 'medium',
        ?string $timeFormat = 'medium',
        ?string $pattern = '',
        $timezone = null,
        string $calendar = 'gregorian',
        string $locale = null
    ): string {
        try {
            $date = $this->convertDate($date, $timezone);
        } catch (Exception $exception) {
            throw new FailedFormatting('Unable to format the given date.', 0, $exception);
        }

        $formatter = $this->createDateFormatter($locale, $dateFormat, $timeFormat, $pattern, $date->getTimezone(), $calendar);
        if (false === $ret = $formatter->format($date)) {
            throw new FailedFormatting('Unable to format the given date.');
        }

        return $ret;
    }

    /**
     * @param DateTimeInterface|string|int|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     *
     * @throws Exception
     */
    private function convertDate($date, $timezone): DateTimeInterface
    {
        // determine the timezone
        if (false !== $timezone) {
            if (null === $timezone) {
                $timezone = Carbon::now()->getTimezone();
            } elseif (!$timezone instanceof DateTimeZone) {
                $timezone = new DateTimeZone($timezone);
            }
        }

        // immutable dates
        if ($date instanceof DateTimeImmutable) {
            return false !== $timezone ? $date->setTimezone($timezone) : $date;
        }

        if ($date instanceof DateTimeInterface) {
            $date = clone $date;
            if (false !== $timezone) {
                $date->setTimezone($timezone);
            }

            return $date;
        }

        $asString = (string) $date;
        if (null === $date || 'now' === strtolower($asString)) {
            return new DateTime('now', false !== $timezone ? $timezone : Carbon::now()->getTimezone());
        }

        if (ctype_digit($asString) || ('' !== $asString && '-' === $asString[0] && ctype_digit(substr($asString, 1)))) {
            $date = new DateTime('@'.$asString);
            $date->setTimezone(false !== $timezone ? $timezone : Carbon::now()->getTimezone());

            return $date;
        }

        return new DateTime($asString, false !== $timezone ? $timezone : Carbon::now()->getTimezone());
    }

    /**
     * @param DateTimeInterface|string|int|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    public function formatDate(
        $date,
        ?string $dateFormat = 'medium',
        ?string $pattern = '',
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
        ?string $timeFormat = 'medium',
        ?string $pattern = '',
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
        if (null !== $dateFormat && !isset(self::DATE_FORMATS[$dateFormat])) {
            throw new FailedFormatting(sprintf('The date format "%s" does not exist, known formats are: "%s".', $dateFormat, implode('", "', array_keys(self::DATE_FORMATS))));
        }

        if (null !== $timeFormat && !isset(self::DATE_FORMATS[$timeFormat])) {
            throw new FailedFormatting(sprintf('The time format "%s" does not exist, known formats are: "%s".', $timeFormat, implode('", "', array_keys(self::DATE_FORMATS))));
        }

        $locale = $locale ?? Locale::getDefault();
        $calendar = 'gregorian' === $calendar ? IntlDateFormatter::GREGORIAN : IntlDateFormatter::TRADITIONAL;
        $dateFormatValue = self::DATE_FORMATS[$dateFormat] ?? $this->dateFormatterPrototype->getDateType();
        $timeFormatValue = self::DATE_FORMATS[$timeFormat] ?? $this->dateFormatterPrototype->getTimeType();
        $pattern = $pattern ?? $this->dateFormatterPrototype->getPattern();

        $hash = $locale.'|'.$dateFormatValue.'|'.$timeFormatValue.'|'.$timezone->getName().'|'.$calendar.'|'.$pattern;
        if (!isset($this->dateFormatters[$hash])) {
            $this->dateFormatters[$hash] = new IntlDateFormatter($locale, $dateFormatValue, $timeFormatValue, $timezone, $calendar, $pattern);
        }

        return $this->dateFormatters[$hash];
    }

    /**
     * @param array<string, string|float|int> $attrs
     */
    private function createNumberFormatter(?string $locale, string $style, array $attrs = []): NumberFormatter
    {
        if (!isset(self::NUMBER_STYLES[$style])) {
            throw new FailedFormatting(sprintf('The style "%s" does not exist, known styles are: "%s".', $style, implode('", "', array_keys(self::NUMBER_STYLES))));
        }

        $locale = $locale ?? Locale::getDefault();

        ksort($attrs);
        $hash = $locale.'|'.$style.'|'.json_encode($attrs);
        if (!isset($this->numberFormatters[$hash])) {
            $newNumberFormatter = new NumberFormatter($locale, self::NUMBER_STYLES[$style]);
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
            if (!isset(self::NUMBER_ATTRIBUTES[$name])) {
                throw new FailedFormatting(sprintf('The number formatter attribute "%s" does not exist, known attributes are: "%s".', $name, implode('", "', array_keys(self::NUMBER_ATTRIBUTES))));
            }

            if ('rounding_mode' === $name) {
                if (!isset(self::NUMBER_ROUNDING_ATTRIBUTES[$value])) {
                    throw new FailedFormatting(sprintf('The number formatter rounding mode "%s" does not exist, known modes are: "%s".', $value, implode('", "', array_keys(self::NUMBER_ROUNDING_ATTRIBUTES))));
                }

                $value = self::NUMBER_ROUNDING_ATTRIBUTES[$value];
            } elseif ('padding_position' === $name) {
                if (!isset(self::NUMBER_PADDING_ATTRIBUTES[$value])) {
                    throw new FailedFormatting(sprintf('The number formatter padding position "%s" does not exist, known positions are: "%s".', $value, implode('", "', array_keys(self::NUMBER_PADDING_ATTRIBUTES))));
                }

                $value = self::NUMBER_PADDING_ATTRIBUTES[$value];
            }

            if (is_string($value)) {
                throw new FailedFormatting(sprintf('The number formatter value for "%s" can not be a string: "%s', $name, $value));
            }

            $numberFormatter->setAttribute(self::NUMBER_ATTRIBUTES[$name], $value);
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
    }
}
