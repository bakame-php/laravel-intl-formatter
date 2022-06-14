<?php

declare(strict_types=1);

namespace Bakame\Intl\Laravel;

use Bakame\Intl\Formatter;
use Illuminate\Support\Facades\Facade;

final class IntlFormatter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Formatter::class;
    }
}
