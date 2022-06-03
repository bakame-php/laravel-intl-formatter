<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

final class Configuration
{
    /** @readonly */
    public int $dateType;
    /** @readonly */
    public int $timeType;
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
        int $dateType,
        int $timeType,
        string $datePattern,
        int $style,
        string $numberPattern,
        array $attributes,
        array $textAttributes,
        array $symbolAttributes
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
     *         pattern:string
     *     },
     *     number:array{
     *         style:int,
     *         pattern:string,
     *         attributes:array<int, int|float>,
     *         textAttributes:array<int,string>,
     *         symbolAttributes:array<int,string>
     *     }
     * } $settings
     */
    public static function fromApplication(array $settings): self
    {
        return new self(
            $settings['date']['dateType'],
            $settings['date']['timeType'],
            $settings['date']['pattern'],
            $settings['number']['style'],
            $settings['number']['pattern'],
            $settings['number']['attributes'],
            $settings['number']['textAttributes'],
            $settings['number']['symbolAttributes'],
        );
    }
}
