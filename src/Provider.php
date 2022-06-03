<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Support\ServiceProvider;

final class Provider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        if (! defined('LARAVEL_BKM_INTL_FORMATTER')) {
            define('LARAVEL_BKM_INTL_FORMATTER', realpath(__DIR__.'/../'));
        }

        $this->mergeConfigFrom(
            LARAVEL_BKM_INTL_FORMATTER.'/config/bakame-intl-formatter.php',
            'bakame-intl-formatter'
        );

        $this->app->singleton('bakame.intl.formatter', fn ($app): Formatter =>
            Formatter::fromConfiguration(
                Configuration::fromApplication($app->make('config')->get('bakame-intl-formatter'))
            )
        );
    }
}
