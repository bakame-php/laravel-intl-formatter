<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use DateTimeZone;
use IntlCalendar;
use IntlTimeZone;

final class Configuration
{
    public string $locale;
    public int $dateType;
    public int $timeType;
    /** @var IntlTimeZone|DateTimeZone|string|null */
    public $timezone;
    /** @var IntlCalendar|int|null */
    public $calendar;
    public string $datePattern;
    public int $style;
    public string $numberPattern;
    /** @var array<int, int|float>  */
    public array $attributes;
    /** @var array<int, string>  */
    public array $textAttributes;

    /**
     * @param array{
     *     locale: string,
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
    public function __construct(array $properties)
    {
        $this->locale = $properties['locale'];
        $this->dateType = $properties['dateType'];
        $this->timeType = $properties['timeType'];
        $this->timezone = $properties['timezone'];
        $this->calendar = $properties['calendar'];
        $this->datePattern = $properties['datePattern'];
        $this->style = $properties['style'];
        $this->numberPattern = $properties['numberPattern'];
        $this->attributes = $properties['attributes'];
        $this->textAttributes = $properties['textAttributes'];
    }
}
