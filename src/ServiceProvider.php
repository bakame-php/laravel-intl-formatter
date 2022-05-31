<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Twig\Extra\Intl\IntlExtension as TwigIntlExtension;

final class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton('bakame.intl.extra', fn (): TwigIntlExtension => new TwigIntlExtension());
    }
}
