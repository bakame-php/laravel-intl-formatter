<?php

declare(strict_types=1);

namespace Bakame\Intl\Laravel;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Money\Money;
use Orchestra\Testbench\TestCase as LaravelTestCase;

final class FactoryTest extends LaravelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('cache:clear');
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
    public function it_can_format_a_money_object(): void
    {
        $money = Money::EUR(250);

        self::assertSame('2,50 €', IntlFactory::newIntlMoneyFormatter('fr', 'currency')->format($money));
        self::assertSame('2,50 €', format_currency($money, null, 'fr'));

        self::assertSame('deux virgule cinq', IntlFactory::newIntlMoneyFormatter('fr', 'spellout')->format($money));
        self::assertSame('deux virgule cinq', format_number($money, 'fr', 'default', [], 'spellout'));
    }
}
