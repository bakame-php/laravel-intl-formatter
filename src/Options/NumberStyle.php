<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl\Options;

use NumberFormatter;

final class NumberStyle extends PseudoEnum
{
    protected const CONSTANTS = [
        'decimal' => NumberFormatter::DECIMAL,
        'currency' => NumberFormatter::CURRENCY,
        'percent' => NumberFormatter::PERCENT,
        'scientific' => NumberFormatter::SCIENTIFIC,
        'spellout' => NumberFormatter::SPELLOUT,
        'ordinal' => NumberFormatter::ORDINAL,
        'duration' => NumberFormatter::DURATION,
    ];

    protected static string $description = 'style';
}
