<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase as LaravelTestCase;

final class BladeTest extends LaravelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    /** @test */
    public function it_can_format_a_country_name(): void
    {
        /** @var string $content */
        $content = $this->renderView('extensions');

        self::assertStringContainsString('country name: Algerij', $content);
        self::assertStringContainsString('currency symbol: ¥', $content);
        self::assertStringContainsString('currency name: CFA-franc BCEAO', $content);
        self::assertStringContainsString('language name: Canadian French', $content);
        self::assertStringContainsString('locale name: Duits', $content);
        self::assertStringContainsString('timezone name: heure normale d’Afrique de l’Est (Nairobi)', $content);
        self::assertStringContainsString('format number: twaalf komma drie vier vij', $content);
        self::assertStringContainsString('format currency: 1,000,000', $content);
        self::assertStringContainsString('country timezones: Africa/Kinshasa, Africa/Lubumbashi', $content);
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('view.paths', [__DIR__.'/../resources/views']);
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
            Provider::class,
        ];
    }
}
