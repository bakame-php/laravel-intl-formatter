<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl\Options;

use Bakame\Laravel\Intl\FailedFormatting;
use NumberFormatter;

final class NumberAttribute
{
    private const ATTRIBUTES = [
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

    private const ROUNDING_MODES = [
        'ceiling' => NumberFormatter::ROUND_CEILING,
        'floor' => NumberFormatter::ROUND_FLOOR,
        'down' => NumberFormatter::ROUND_DOWN,
        'up' => NumberFormatter::ROUND_UP,
        'halfeven' => NumberFormatter::ROUND_HALFEVEN,
        'halfdown' => NumberFormatter::ROUND_HALFDOWN,
        'halfup' => NumberFormatter::ROUND_HALFUP,
    ];

    private const PADDING_POSITIONS = [
        'before_prefix' => NumberFormatter::PAD_BEFORE_PREFIX,
        'after_prefix' => NumberFormatter::PAD_AFTER_PREFIX,
        'before_suffix' => NumberFormatter::PAD_BEFORE_SUFFIX,
        'after_suffix' => NumberFormatter::PAD_AFTER_SUFFIX,
    ];

    /**
     * @readonly
     *
     * @var int|float
     */
    public $value;

    /** @readonly */
    public int $name;

    /**
     * @param int|float $value
     */
    private function __construct(int $name, $value)
    {
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @param int|float|string $value
     */
    public static function from(string $name, $value): self
    {
        if (!isset(self::ATTRIBUTES[$name])) {
            throw FailedFormatting::dueToUnknownNumberFormatterAttributeName($name, self::ATTRIBUTES);
        }

        $attributeName = self::ATTRIBUTES[$name];

        if (NumberFormatter::ROUNDING_MODE === $attributeName) {
            if (!isset(self::ROUNDING_MODES[$value])) {
                throw FailedFormatting::dueToUnknownNumberFormatterRoundingMode($name, self::ROUNDING_MODES);
            }

            return new self($attributeName, self::ROUNDING_MODES[$value]);
        }

        if (NumberFormatter::PADDING_POSITION === $attributeName) {
            if (!isset(self::PADDING_POSITIONS[$value])) {
                throw FailedFormatting::dueToUnknownNumberFormatterPaddingPosition($name, self::PADDING_POSITIONS);
            }

            return new self($attributeName, self::PADDING_POSITIONS[$value]);
        }

        if (is_string($value)) {
            throw FailedFormatting::dueToInvalidNumberFormatterAttributeValue($name, $value);
        }

        return new self($attributeName, $value);
    }

    public function addTo(NumberFormatter $numberFormatter): void
    {
        $numberFormatter->setAttribute($this->name, $this->value);
    }
}
