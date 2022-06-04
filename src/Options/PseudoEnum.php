<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl\Options;

use Bakame\Laravel\Intl\FailedFormatting;

abstract class PseudoEnum
{
    protected const CONSTANTS = [];

    protected static string $description = '';

    /** @readonly */
    public int $value;

    /** @readonly */
    public string $name;

    final public function __construct(int $value)
    {
        $name = array_search($value, static::CONSTANTS, true);
        if (!is_string($name)) {
            throw new FailedFormatting('Unsupported constants.');
        }
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @return static
     */
    public static function fromName(string $name): self
    {
        if (!isset(static::CONSTANTS[$name])) {
            throw FailedFormatting::dueToUnknownOptions(static::$description, $name, static::CONSTANTS);
        }

        return new static(static::CONSTANTS[$name]);
    }

    /**
     * @return static
     */
    public static function from(int $value): self
    {
        return new static($value);
    }

    /**
     * @return static
     */
    public static function tryFrom(int $value): ?self
    {
        try {
            return static::from($value);
        } catch (FailedFormatting $exception) {
            return null;
        }
    }
}
