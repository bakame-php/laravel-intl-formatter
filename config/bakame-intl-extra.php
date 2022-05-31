<?php

return [
    'locale' => 'fr',
    'dateType' => IntlDateFormatter::FULL,
    'timeType' => IntlDateFormatter::FULL,
    'timezone' => null,
    'calendar' => null,
    'datePattern' => '',
    'style' => NumberFormatter::DECIMAL,
    'numberPattern' => '',
    'attributes' => [
        NumberFormatter::FRACTION_DIGITS => 1,
    ],
    'textAttributes' => [
        NumberFormatter::POSITIVE_PREFIX => '++',
    ],
];

