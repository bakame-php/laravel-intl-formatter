<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Support\ServiceProvider;

final class FormatterProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton('bakame.intl.formatter', fn (): Formatter => Formatter::fromEnvironment());
    }
}
