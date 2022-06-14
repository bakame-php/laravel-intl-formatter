<?php

declare(strict_types=1);

namespace Bakame\Intl\Laravel;

use Illuminate\Support\Facades\Facade;

final class IntlFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Factory::class;
    }
}
