<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl\Options;

use Bakame\Laravel\Intl\FailedFormatting;
use IntlDateFormatter;
use PHPUnit\Framework\TestCase;

final class DateTypeTest extends TestCase
{
    /** @test */
    public function it_can_return_a_data_type_objec(): void
    {
        self::assertSame('none', DateType::from(IntlDateFormatter::NONE)->name);
        self::assertSame(IntlDateFormatter::FULL, DateType::fromName('full')->value);
    }

    /** @test */
    public function it_fails_with_invalid_constant_name(): void
    {
        $this->expectException(FailedFormatting::class);

        DateType::fromName('foobar');
    }

    /** @test */
    public function it_throws_with_invalid_constant_value_using_from(): void
    {
        $this->expectException(FailedFormatting::class);

        DateType::from(PHP_INT_MAX);
    }

    /** @test */
    public function it_returns_null_with_invalid_constant_value_using_tryfrom(): void
    {
        self::assertNull(DateType::tryFrom(PHP_INT_MAX));
    }
}
