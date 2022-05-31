<?php

declare(strict_types=1);

namespace BakameTest\Laravel\Intl;

use Bakame\Laravel\Intl\ServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase as LaravelTestCase;

class TestCase extends LaravelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('view.paths', [__DIR__ . '/../resources/views']);
    }

    /**
     * @param array<string, mixed> $withParameters
     *
     * @throws BindingResolutionException
     *
     * @return array<string>|string
     */
    public function renderView(string $viewName, array $withParameters = [])
    {
        return app(ViewFactory::class)->make($viewName, $withParameters)->render();
    }

    /**
     * @param Application $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }
}
