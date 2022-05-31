<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Support\Facades\Facade;

final class IntlExtension extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bakame.intl.extra';
    }
}
