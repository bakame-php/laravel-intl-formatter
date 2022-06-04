<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Bakame\Laravel\Intl\Options\DateType;
use Bakame\Laravel\Intl\Options\NumberStyle;
use Bakame\Laravel\Intl\Options\TimeType;

final class Configuration
{
    /** @readonly */
    public DateType $dateType;
    /** @readonly */
    public TimeType $timeType;
    /** @readonly */
    public NumberStyle $style;
    /** @readonly */
    public ?string $datePattern;
    /** @readonly */
    public ?string $numberPattern;
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
     * @readonly
     * @var array<int, string>
     */
    public array $symbolAttributes;

    /**
     * @param array<int, int|float> $attributes
     * @param array<int, string> $textAttributes
     * @param array<int, string> $symbolAttributes
     */
    public function __construct(
        DateType    $dateType,
        TimeType    $timeType,
        NumberStyle $style,
        ?string     $datePattern = null,
        ?string     $numberPattern = null,
        array       $attributes = [],
        array       $textAttributes = [],
        array       $symbolAttributes = []
    ) {
        $this->dateType = $dateType;
        $this->timeType = $timeType;
        $this->datePattern = $datePattern;
        $this->style = $style;
        $this->numberPattern = $numberPattern;
        $this->attributes = $attributes;
        $this->textAttributes = $textAttributes;
        $this->symbolAttributes = $symbolAttributes;
    }

    /**
     * @param array{
     *     date:array{
     *         dateType:int,
     *         timeType:int,
     *         pattern?:?string
     *     },
     *     number:array{
     *         style:int,
     *         pattern?:?string,
     *         attributes?:array<int, int|float>,
     *         textAttributes?:array<int,string>,
     *         symbolAttributes?:array<int,string>
     *     }
     * } $settings
     */
    public static function fromApplication(array $settings): self
    {
        if (!array_key_exists('pattern', $settings['date'])) {
            $settings['date']['pattern'] = null;
        }

        if (!array_key_exists('pattern', $settings['number'])) {
            $settings['number']['pattern'] = null;
        }

        if (!array_key_exists('attributes', $settings['number'])) {
            $settings['number']['attributes'] = [];
        }

        if (!array_key_exists('textAttributes', $settings['number'])) {
            $settings['number']['textAttributes'] = [];
        }

        if (!array_key_exists('symbolAttributes', $settings['number'])) {
            $settings['number']['symbolAttributes'] = [];
        }

        return new self(
            DateType::from($settings['date']['dateType']),
            TimeType::from($settings['date']['timeType']),
            NumberStyle::from($settings['number']['style']),
            $settings['date']['pattern'],
            $settings['number']['pattern'],
            $settings['number']['attributes'],
            $settings['number']['textAttributes'],
            $settings['number']['symbolAttributes'],
        );
    }
}
