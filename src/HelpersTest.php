<?php

declare(strict_types=1);

namespace Bakame\Intl\Laravel;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase as LaravelTestCase;

final class HelpersTest extends LaravelTestCase
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
        $app['config']->set('view.paths', [__DIR__.'/../test_files']);
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

    /** @test */
    public function it_can_format_a_country_name(): void
    {
        /** @var string $content */
        $content = $this->renderView('country_name');
        $expected = <<<EXPECTED
UNKNOWN

France
United States
États-Unis
Suisse
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }

    /** @test */
    public function it_can_format_a_country_timezones(): void
    {
        /** @var string $content */
        $content = $this->renderView('country_timezones');
        $expected = <<<EXPECTED
0
Europe/Paris
America/Adak, America/Anchorage, America/Boise, America/Chicago, America/Denver, America/Detroit, America/Indiana/Knox, America/Indiana/Marengo, America/Indiana/Petersburg, America/Indiana/Tell_City, America/Indiana/Vevay, America/Indiana/Vincennes, America/Indiana/Winamac, America/Indianapolis, America/Juneau, America/Kentucky/Monticello, America/Los_Angeles, America/Louisville, America/Menominee, America/Metlakatla, America/New_York, America/Nome, America/North_Dakota/Beulah, America/North_Dakota/Center, America/North_Dakota/New_Salem, America/Phoenix, America/Sitka, America/Yakutat, Pacific/Honolulu
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }

    /** @test */
    public function it_can_format_a_currency_name(): void
    {
        /** @var string $content */
        $content = $this->renderView('currency_name');
        $expected = <<<EXPECTED
UNKNOWN

Euro
Japanese Yen
euro
yen japonais
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }

    /** @test */
    public function it_can_format_a_currency_symbol(): void
    {
        /** @var string $content */
        $content = $this->renderView('currency_symbol');
        $expected = <<<EXPECTED
UNKNOWN

€
¥
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }

    /** @test */
    public function it_can_format_currency(): void
    {
        /** @var string $content */
        $content = $this->renderView('format_currency');
        $expected = <<<EXPECTED
€1,000,000.00
1.000.000,00 €
€1,000,000.00
€12.34
YEN 125,000.00
€12.34
EXPECTED;
        foreach (explode(PHP_EOL, $expected) as $expectedLine) {
            self::assertStringContainsString($expectedLine, $content);
        }
    }

    /** @test */
    public function it_can_format_date(): void
    {
        /** @var string $content */
        $content = $this->renderView('format_date');
        $expected = <<<EXPECTED
Aug 7, 2019, 11:39:12 PM
7 août 2019 à 23:39:12
23:39
07/08/2019
mercredi 7 août 2019 à 23:39:12 Temps universel coordonné
11 oclock PM, Coordinated Universal Time

Aug 7, 2019
7 août 2019
11:39:12 PM
EXPECTED;

        foreach (explode(PHP_EOL, $expected) as $expectedLine) {
            self::assertStringContainsString($expectedLine, $content);
        }
    }

    /** @test */
    public function it_can_format_number(): void
    {
        /** @var string $content */
        $content = $this->renderView('format_number');
        $expected = <<<EXPECTED
12.345
12,345
1,234%
twelve point three four five
1,234%
twelve point three four five
quatre-vingts virgule trois quatre cinq
huitante virgule trois quatre cinq
12 sec.
12.0%
13%
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }

    /** @test */
    public function it_can_format_language_name(): void
    {
        /** @var string $content */
        $content = $this->renderView('language_name');
        $expected = <<<EXPECTED
UNKNOWN

German
French
allemand
français
français canadien
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }

    /** @test */
    public function it_can_format_locale_name(): void
    {
        /** @var string $content */
        $content = $this->renderView('locale_name');
        $expected = <<<EXPECTED
UNKNOWN

German
French
allemand
français
français (Canada)
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }

    /** @test */
    public function it_can_format_timezone_name(): void
    {
        /** @var string $content */
        $content = $this->renderView('timezone_name');
        $expected = <<<EXPECTED
UNKNOWN

Central European Time (Paris)
Pacific Time (Los Angeles)
heure du Pacifique nord-américain (Los Angeles)
EXPECTED;
        self::assertStringContainsString($expected, $content);
    }
}
