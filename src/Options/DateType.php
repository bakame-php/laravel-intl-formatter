<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl\Options;

use IntlDateFormatter;

final class DateType extends PseudoEnum
{
    protected const CONSTANTS = [
        'none' => IntlDateFormatter::NONE,
        'short' => IntlDateFormatter::SHORT,
        'medium' => IntlDateFormatter::MEDIUM,
        'long' => IntlDateFormatter::LONG,
        'full' => IntlDateFormatter::FULL,
    ];

    protected static string $description = 'date format';

}
