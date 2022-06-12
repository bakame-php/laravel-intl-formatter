<?php

declare(strict_types=1);

namespace Bakame\Intl\Laravel;

use Bakame\Intl\DateFactory;
use Bakame\Intl\DateResolver;
use Bakame\Intl\Formatter;
use Bakame\Intl\NumberFactory;

final class Factory
{
    private DateFactory $dateFactory;
    private NumberFactory $numberFactory;

    public function __construct(DateFactory $dateFactory, NumberFactory $numberFactory)
    {
        $this->dateFactory = $dateFactory;
        $this->numberFactory = $numberFactory;
    }

    /**
     * @param array{
     *     date:array{
     *         dateFormat:string,
     *         timeFormat:string,
     *         calendar:string,
     *         pattern?:?string
     *     },
     *     number:array{
     *         style:string,
     *         attributes:array<string, int|float|string>,
     *         textAttributes:array<string, string>,
     *         symbolAttributes:array<string, string>,
     *         pattern?:?string
     *     }
     * } $settings
     */
    public static function fromAssociative(array $settings): self
    {
        return new self(
            DateFactory::fromAssociative($settings['date']),
            NumberFactory::fromAssociative($settings['number'])
        );
    }

    public function newFormatter(DateResolver $dateResolver): Formatter
    {
        return new Formatter(
            $this->dateFactory,
            $this->numberFactory,
            $dateResolver
        );
    }
}
