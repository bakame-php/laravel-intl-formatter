<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Bakame\Intl\Configuration;
use Bakame\Intl\DateResolver;
use Bakame\Intl\Formatter;
use Bakame\Intl\SystemDateResolver;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

final class Provider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        if (! defined('BKM_INTL_FORMATTER')) {
            define('BKM_INTL_FORMATTER', realpath(__DIR__.'/../'));
        }

        $this->mergeConfigFrom(BKM_INTL_FORMATTER.'/config/bakame-intl-formatter.php', 'bakame.intl.formatter.settings');
        $this->app->singleton('bakame.date.resolver', fn (): DateResolver => SystemDateResolver::fromTimeZone(
            Carbon::now()->getTimezone()
        ));
        $this->app->singleton('bakame.intl.formatter.config', fn ($app): Configuration => Configuration::fromApplication(
            $app->make('config')->get('bakame.intl.formatter.settings')
        ));
        $this->app->singleton('bakame.intl.formatter', fn ($app): Formatter => new Formatter(
            $app->make('bakame.intl.formatter.config'),
            $app->make('bakame.date.resolver')
        ));
    }
}
