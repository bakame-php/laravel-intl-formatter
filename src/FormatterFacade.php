<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Support\Facades\Facade;

final class FormatterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bakame.intl.formatter';
    }
}
