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
        self::assertSame("country name: Frankrijk", $this->renderView('country_name', ['country' => 'FR', 'locale' => 'NL']));
    }

    /**
     * @test
     */
    public function it_can_format_a_currency(): void
    {
        self::assertSame('format currency: ¥5,000,000.0000', $this->renderView('format_currency', [
            'amount' => 5000000,
            'currency' => 'JPY',
            'attributes' => [
                'rounding_mode' => 'floor',
                'fraction_digit' => 4,
            ],
        ]));
    }
}