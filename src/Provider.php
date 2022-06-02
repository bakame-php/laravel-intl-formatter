<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Support\ServiceProvider;
use Twig\Extra\Intl\IntlExtension as TwigIntlExtension;

final class Provider extends ServiceProvider
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
            fn ($app): Factory =>
             Factory::fromConfiguration(
                 Configuration::fromSettings($app->make('config')->get('bakame-intl-extra'))
             )
        );

        $this->app->singleton(
            'bakame.intl.extra',
            function (): TwigIntlExtension {
                /** @var Factory $factory */
                $factory = $this->app->make('bakame.intl.factory');

                return $factory->newInstance();
            }
        );
    }
}
