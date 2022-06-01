<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use DateTimeZone;
use IntlCalendar;
use IntlTimeZone;

final class Configuration
{
    /** @readonly */
    public ?string $locale;
    /** @readonly */
    public int $dateType;
    /** @readonly */
    public int $timeType;
    /**
     * @readonly
     * @var IntlTimeZone|DateTimeZone|string|null
     */
    public $timezone;
    /**
     * @readonly
     * @var IntlCalendar|int|null
     */
    public $calendar;
    /** @readonly */
    public string $datePattern;
    /** @readonly */
    public int $style;
    /** @readonly */
    public string $numberPattern;
    /**
     * @readonly
     * @var array<int, int|float>
     */
    public array $attributes;
    /**
     * @readonly
     * @var array<int, string>
     */
    public array $textAttributes;

    /**
     * @param IntlTimeZone|DateTimeZone|string|null $timezone
     * @param IntlCalendar|int|null                 $calendar
     * @param array<int, int|float>                 $attributes
     * @param array<int, string>                    $textAttributes
     */
    public function __construct(
        ?string $locale,
        int $dateType,
        int $timeType,
        $timezone,
        $calendar,
        string $datePattern,
        int $style,
        string $numberPattern,
        array $attributes = [],
        array $textAttributes = []
    ) {
        $this->locale = $locale;
        $this->dateType = $dateType;
        $this->timeType = $timeType;
        $this->timezone = $timezone;
        $this->calendar = $calendar;
        $this->datePattern = $datePattern;
        $this->style = $style;
        $this->numberPattern = $numberPattern;
        $this->attributes = $attributes;
        $this->textAttributes = $textAttributes;
    }

    /**
     * @param array{
     *     locale: ?string,
     *     dateType:int,
     *     timeType:int,
     *     timezone:IntlTimeZone|DateTimeZone|string|null,
     *     calendar:IntlCalendar|int|null,
     *     datePattern: string,
     *     style:int,
     *     numberPattern:string,
     *     attributes:array<int, int|float>,
     *     textAttributes:array<int, string>
     * } $properties
     */
    public static function fromSettings(array $properties): self
    {
        return new self(
            $properties['locale'],
            $properties['dateType'],
            $properties['timeType'],
            $properties['timezone'],
            $properties['calendar'],
            $properties['datePattern'],
            $properties['style'],
            $properties['numberPattern'],
            $properties['attributes'],
            $properties['textAttributes'],
        );
    }
}
