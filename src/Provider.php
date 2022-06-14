<?php

declare(strict_types=1);

namespace Bakame\Intl\Laravel;

use Bakame\Intl\DateResolver;
use Bakame\Intl\Formatter;
use Illuminate\Support\ServiceProvider;

final class Provider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                BKM_INTL_FORMATTER.'/config/bakame-intl-formatter.php' => config_path('bakame-intl-formatter.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        parent::register();

        if (! defined('BKM_INTL_FORMATTER')) {
            define('BKM_INTL_FORMATTER', realpath(__DIR__.'/../'));
        }

        $this->mergeConfigFrom(BKM_INTL_FORMATTER.'/config/bakame-intl-formatter.php', 'bakame.intl.laravel.configuration');

        $this->app->singleton(DateResolver::class, fn (): DateResolver => DateResolver::fromTimeZone(now()->getTimezone()));
        $this->app->singleton(Factory::class, fn ($app): Factory => Factory::fromAssociative(
            $app->make('config')->get('bakame.intl.laravel.configuration')
        ));
        $this->app->singleton(Formatter::class, fn ($app): Formatter =>
            $app->make(Factory::class)->newFormatter($app->make(DateResolver::class))
        );
    }
}
