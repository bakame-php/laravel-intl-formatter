<?php

declare(strict_types=1);

namespace Bakame\Intl\Laravel;

use Bakame\Intl\DateFactory;
use Bakame\Intl\DateResolver;
use Bakame\Intl\Formatter;
use Bakame\Intl\NumberFactory;
use Bakame\Intl\Option\AttributeFormat;
use Bakame\Intl\Option\CalendarFormat;
use Bakame\Intl\Option\DateFormat;
use Bakame\Intl\Option\PaddingPosition;
use Bakame\Intl\Option\RoundingMode;
use Bakame\Intl\Option\StyleFormat;
use Bakame\Intl\Option\SymbolFormat;
use Bakame\Intl\Option\TextFormat;
use Bakame\Intl\Option\TimeFormat;
use Locale;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

final class Factory
{
    /** @readonly */
    public DateFactory $dateFactory;
    /** @readonly */
    public NumberFactory $numberFactory;

    public function __construct(DateFactory $dateFactory, NumberFactory $numberFactory)
    {
        $this->dateFactory = $dateFactory;
        $this->numberFactory = $numberFactory;
    }

    /**
     * @param array{
     *     date:array{
     *         dateFormat:key-of<DateFormat::INTL_MAPPER>,
     *         timeFormat:key-of<TimeFormat::INTL_MAPPER>,
     *         calendar:key-of<CalendarFormat::INTL_MAPPER>,
     *         pattern?:?string,
     *     },
     *     number:array{
     *         style:key-of<StyleFormat::INTL_MAPPER>,
     *         pattern?:?string,
     *         attributes?:array<key-of<AttributeFormat::INTL_MAPPER>, int|float|key-of<RoundingMode::INTL_MAPPER>|key-of<PaddingPosition::INTL_MAPPER>>,
     *         textAttributes?:array<key-of<TextFormat::INTL_MAPPER>, string>,
     *         symbolAttributes?:array<key-of<SymbolFormat::INTL_MAPPER>, string>
     *     }
     * } $settings
     */
    public static function fromAssociative(array $settings): self
    {
        return new self(
            DateFactory::fromAssociative($settings['date']),
            NumberFactory::fromAssociative($settings['number'])
        );
    }

    public function newFormatter(DateResolver $dateResolver): Formatter
    {
        return new Formatter(
            $this->dateFactory,
            $this->numberFactory,
            $dateResolver
        );
    }

    /**
     * @param array<key-of<AttributeFormat::INTL_MAPPER>, int|float|key-of<RoundingMode::INTL_MAPPER>|key-of<PaddingPosition::INTL_MAPPER>> $attrs
     */
    public function newIntlMoneyFormatter(?string $locale = null, ?string $style = null, array $attrs = []): IntlMoneyFormatter
    {
        $locale = $locale ?? Locale::getDefault();
        $hash = $locale.'|'.json_encode($attrs);
        static $instances = [];
        if (!isset($instances[$hash])) {
            $instances[$hash] = new IntlMoneyFormatter(
                $this->numberFactory->createNumberFormatter($locale, $style, $attrs),
                new ISOCurrencies()
            );
        }

        return $instances[$hash];
    }
}
