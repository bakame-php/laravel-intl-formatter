<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use RuntimeException;
use Throwable;

final class FailedFormatting extends RuntimeException
{
    /** @codeCoverageIgnore */
    public static function dueToNumberFormatter(string $message): self
    {
        return new self($message);
    }

    /** @codeCoverageIgnore */
    public static function dueToDateFormatter(string $message): self
    {
        return new self($message);
    }

    public static function dueToInvalidDate(Throwable $exception = null): self
    {
        return new self('Unable to format the given date.', 0, $exception);
    }

    /**
     * @param array<string,mixed> $supported
     */
    public static function dueToUnknownOptions(string $name, string $format, array $supported): self
    {
        return new self('The '.$name.' "'.$format.'" does not exist; expecting one value of : "'.implode('", "', array_keys($supported)).'".');
    }

    /**
     * @param array<string,mixed> $supported
     */
    public static function dueToUnknownNumberFormatterAttributeName(string $name, array $supported): self
    {
        return new self('The number formatter attribute "'.$name.'" does not exist, known attributes are: "'.implode('", "', array_keys($supported)).'".');
    }

    /**
     * @param float|int|string $value
     * @param array<string,mixed> $supported
     */
    public static function dueToUnknownNumberFormatterRoundingMode($value, array $supported): self
    {
        return new self('The number formatter rounding mode "'.$value.'" does not exist, known modes are: "'.implode('", "', array_keys($supported)).'".');
    }

    /**
     * @param float|int|string $value
     * @param array<string,mixed> $supported
     */
    public static function dueToUnknownNumberFormatterPaddingPosition($value, array $supported): self
    {
        return new self('The number formatter padding position "'.$value.'" does not exist, known positions are: "'.implode('", "', array_keys($supported)).'".');
    }

    /**
     * @param int|float|string $value
     */
    public static function dueToInvalidNumberFormatterAttributeValue(string $name, $value): self
    {
        return new self('The number formatter value for "'.$name.'" can not be a string: "'.$value.'"');
    }
}
