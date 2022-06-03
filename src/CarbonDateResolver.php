<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Illuminate\Support\Carbon;

final class CarbonDateResolver implements DateResolver
{
    /**
     * @param DateTimeInterface|string|int|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     *
     * @throws Exception
     */
    public function resolve($date, $timezone): DateTimeInterface
    {
        $timezone = $this->determineTheTimezone($timezone);
        if ($date instanceof DateTimeImmutable) {
            return null !== $timezone ? $date->setTimezone($timezone) : $date;
        }

        if ($date instanceof DateTime) {
            $date = DateTimeImmutable::createFromMutable($date);

            return null !== $timezone ? $date->setTimezone($timezone) : $date;
        }

        $asString = (string) $date;
        if (null === $date || 'now' === strtolower($asString)) {
            return new DateTimeImmutable('now', $timezone);
        }

        if (1 === preg_match('/^-?\d+$/', $asString)) {
            $date = new DateTimeImmutable('@'.$asString);

            return null !== $timezone ? $date->setTimezone($timezone) : $date;
        }

        return new DateTimeImmutable($asString, $timezone);
    }

    /**
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     */
    public function determineTheTimezone($timezone): ?DateTimeZone
    {
        if (null === $timezone) {
            return Carbon::now()->getTimezone();
        }

        if (false === $timezone) {
            return null;
        }

        if ($timezone instanceof DateTimeZone) {
            return $timezone;
        }

        return new DateTimeZone($timezone);
    }
}
