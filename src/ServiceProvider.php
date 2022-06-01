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

        if (! defined('LARAVEL_BKM_INTL_EXTRA')) {
            define('LARAVEL_BKM_INTL_EXTRA', realpath(__DIR__.'/../'));
        }

        $this->mergeConfigFrom(
            LARAVEL_BKM_INTL_EXTRA.'/config/bakame-intl-extra.php',
            'bakame-intl-extra'
        );

        $this->app->singleton(
            'bakame.intl.factory',
            fn ($app) =>
             Factory::fromConfiguration(
                 Configuration::fromSettings($app->make('config')->get('bakame-intl-extra'))
             )
        );

        $this->app->singleton(
            'bakame.intl.extra',
            fn (): TwigIntlExtension =>
                $this->app->make('bakame.intl.factory')->newInstance() /* @phpstan-ignore-line */
        );
    }
}
