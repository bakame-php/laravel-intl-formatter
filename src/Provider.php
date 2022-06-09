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

        $this->mergeConfigFrom(BKM_INTL_FORMATTER.'/config/bakame-intl-formatter.php', 'bakame.intl.formatter.settings');

        $this->app->singleton('bakame.date.resolver', fn (): DateResolver => DateResolver::fromTimeZone(now()->getTimezone()));
        $this->app->singleton('bakame.intl.formatter.factory', fn ($app): Factory => Factory::fromAssociative(
            $app->make('config')->get('bakame.intl.formatter.settings')
        ));
        $this->app->singleton(
            'bakame.intl.formatter',
            fn ($app): Formatter => $app->make('bakame.intl.formatter.factory')->newInstance(
                $app->make('bakame.date.resolver')
            )
        );
    }
}
