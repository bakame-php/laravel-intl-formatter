<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Support\Facades\App;
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
        $locale = $configuration->locale ?? App::currentLocale();

        return new self(
            new IntlDateFormatter(
                $locale,
                $configuration->dateType,
                $configuration->timeType,
                $configuration->timezone,
                $configuration->calendar,
                $configuration->datePattern
            ),
            self::newNumberFormatter($locale, $configuration)
        );
    }

    private static function newNumberFormatter(string $locale, Configuration $configuration): NumberFormatter
    {
        $numberFormatter = new NumberFormatter(
            $locale,
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
