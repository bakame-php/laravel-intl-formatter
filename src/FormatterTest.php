<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use IntlDateFormatter;
use NumberFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Bakame\Laravel\Intl\Formatter
 */
final class FormatterTest extends TestCase
{
    private Formatter $formatter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatter = Formatter::fromConfiguration(new Configuration(
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            NumberFormatter::DECIMAL
        ));
    }

    /** @test */
    public function it_can_be_instantiated_with_a_different_configuration(): void
    {
        $configuration = new Configuration(
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            NumberFormatter::DECIMAL,
            '',
            '',
            [NumberFormatter::FRACTION_DIGITS => 1],
            [NumberFormatter::POSITIVE_PREFIX => '++'],
            [NumberFormatter::DECIMAL_SEPARATOR_SYMBOL => 'x'],
        );

        $formatter = new Formatter(
            new IntlDateFormatter('fr', IntlDateFormatter::FULL, IntlDateFormatter::FULL),
            $configuration
        );

        self::assertSame('++12x3', $formatter->formatNumber(12.3456, ['padding_position' => 'after_prefix'], 'decimal', 'default', 'fr'));
    }

    /** @test */
    public function it_can_handle_date_type(): void
    {
        $dateString = '2019-08-07 23:39:12';
        $dateImmutable = new DateTimeImmutable('2019-08-07 23:39:12');
        $date = new DateTime('2019-08-07 23:39:12');

        self::assertSame('Jun 3, 2022', $this->formatter->formatDate(1654247542));
        self::assertSame('Jun 3, 2022', $this->formatter->formatDate('1654247542'));
        self::assertSame($this->formatter->formatDate(null), $this->formatter->formatDate('NoW'));
        self::assertSame($this->formatter->formatDate($date), $this->formatter->formatDate($dateImmutable));
        self::assertSame($this->formatter->formatDate($date), $this->formatter->formatDate($dateString));
        self::assertSame(
            $this->formatter->formatDate($dateString, 'short', null, 'Africa/Kinshasa'),
            $this->formatter->formatDate($dateString, 'short', null, new DateTimeZone('Africa/Kinshasa'))
        );
    }

    /** @test */
    public function it_fails_to_format_an_invalid_date(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatDate('foobar');
    }

    /** @test */
    public function it_fails_to_format_a_date_with_an_invalid_date_format(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatDate('2019-08-07 23:39:12', 'foobar');
    }

    /** @test */
    public function it_fails_to_format_a_time_with_an_invalid_time_format(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatTime('2019-08-07 23:39:12', 'foobar');
    }

    /** @test */
    public function it_fails_to_format_a_number_with_invalid_style(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatNumber(42, [], 'foobar');
    }

    /** @test */
    public function it_fails_to_format_a_number_with_invalid_type(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatNumber(42, [], 'decimal', 'foobar');
    }

    /** @test */
    public function it_fails_to_format_a_number_with_unknown_attributes(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatNumber(42, ['foobar' => 1]);
    }

    /** @test */
    public function it_fails_to_format_a_number_with_invalid_rouding_mode_attributes(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatNumber(42, ['rounding_mode' => 'foobar']);
    }

    /** @test */
    public function it_fails_to_format_a_number_with_invalid_padding_position_attributes(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatNumber(42, ['padding_position' => 'foobar']);
    }

    /** @test */
    public function it_fails_to_format_a_number_with_invalid_attributes_value(): void
    {
        $this->expectException(FailedFormatting::class);

        $this->formatter->formatNumber(42, ['grouping_used' => 'foobar']);
    }
}
