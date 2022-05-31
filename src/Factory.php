<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use IntlDateFormatter;
use NumberFormatter;
use Twig\Extra\Intl\IntlExtension as TwigIntlExtension;

final class Factory
{
    private ?IntlDateFormatter $dateFormatter;
    private ?NumberFormatter $numberFormatter;

    public function __construct(?IntlDateFormatter $dateFormatter, ?NumberFormatter $numberFormatter)
    {
        $this->dateFormatter = $dateFormatter;
        $this->numberFormatter = $numberFormatter;
    }

    public static function fromConfiguration(Configuration $configuration): self
    {
        return new self(
            new IntlDateFormatter(
                $configuration->locale,
                $configuration->dateType,
                $configuration->timeType,
                $configuration->timezone,
                $configuration->calendar,
                $configuration->datePattern
            ),
            self::newNumberFormatter($configuration)
        );
    }

    private static function newNumberFormatter(Configuration $configuration): NumberFormatter
    {
        $numberFormatter = new NumberFormatter(
            $configuration->locale,
            $configuration->style,
            $configuration->numberPattern
        );

        foreach ($configuration->attributes as $offset => $value) {
            $numberFormatter->setAttribute($offset, $value);
        }

        foreach ($configuration->textAttributes as $offset => $value) {
            $numberFormatter->setTextAttribute($offset, $value);
        }
        return $numberFormatter;
    }

    public function newInstance(): TwigIntlExtension
    {
        return new TwigIntlExtension($this->dateFormatter, $this->numberFormatter);
    }
}
