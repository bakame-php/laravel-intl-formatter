<?php

declare(strict_types=1);

namespace BakameTest\Laravel\Intl;

final class BladeTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_format_a_country_name(): void
    {
        self::assertSame("country name: Frankrijk", $this->renderView('country_name', ['country' => 'FR', 'locale' => 'nl-BE']));
    }

    /**
     * @test
     */
    public function it_can_format_a_number(): void
    {
        self::assertSame('format currency: ++12,3'.PHP_EOL, $this->renderView('format_currency', ['amount' => 12.3456]));
    }
}
