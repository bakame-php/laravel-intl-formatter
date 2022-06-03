<?php

declare(strict_types=1);

namespace Bakame\Laravel\Intl;

use DateTimeInterface;
use DateTimeZone;
use Exception;

interface DateResolver
{
    /**
     * @param DateTimeInterface|string|int|null $date A date or null to use the current time
     * @param DateTimeZone|string|false|null $timezone The target timezone, null to use the default, false to leave unchanged
     *
     * @throws Exception
     */
    public function resolve($date, $timezone): DateTimeInterface;
}
