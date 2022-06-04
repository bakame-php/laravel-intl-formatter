<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl\Options;

use NumberFormatter;

final class NumberType extends PseudoEnum
{
    protected const CONSTANTS = [
        'default' => NumberFormatter::TYPE_DEFAULT,
        'int32' => NumberFormatter::TYPE_INT32,
        'int64' => NumberFormatter::TYPE_INT64,
        'double' => NumberFormatter::TYPE_DOUBLE,
        'currency' => NumberFormatter::TYPE_CURRENCY,
    ];

    protected static string $description = 'type';
}
