<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | Locale to use when formatting or parsing or null to use the value specified in the ini setting intl.default_locale.
    |
    | Refer to the docs for more information: https://www.php.net/manual/en/intldateformatter.create.php
    |
    | Expected: string|null
    */

    'locale' => 'fr',

    /*
    |--------------------------------------------------------------------------
    | Date Type
    |--------------------------------------------------------------------------
    |
    | Date type to use (none, short, medium, long, full). This is one of the IntlDateFormatter constants.
    |
    | Refer to the docs for more information: https://www.php.net/manual/en/intldateformatter.create.php
    |
    | Expected: string|null
    */

    'dateType' => IntlDateFormatter::FULL,

    /*
    |--------------------------------------------------------------------------
    | Time Type
    |--------------------------------------------------------------------------
    |
    | Time type to use (none, short, medium, long, full). This is one of the IntlDateFormatter constants.
    |
    | Refer to the docs for more information: https://www.php.net/manual/en/intldateformatter.create.php
    |
    | Expected: string|null
    */

    'timeType' => IntlDateFormatter::FULL,

    /*
    |--------------------------------------------------------------------------
    | Time Type
    |--------------------------------------------------------------------------
    |
    | Time zone ID. The default (and the one used if null is given) is the one returned by date_default_timezone_get()
    | or, if applicable, that of the IntlCalendar object passed for the calendar parameter.
    | This ID must be a valid identifier on ICUʼs database or an ID representing an explicit offset, such as GMT-05:30.
    |
    | Refer to the docs for more information: https://www.php.net/manual/en/intldateformatter.create.php
    |
    | Expected: IntlTimeZone|DateTimeZone|string|null
    */

    'timezone' => null,

    /*
    |--------------------------------------------------------------------------
    | Calendar
    |--------------------------------------------------------------------------
    |
    | Calendar to use for formatting or parsing. The default value is null, which corresponds to
    | IntlDateFormatter::GREGORIAN. This can either be one of the IntlDateFormatter calendar
    | constants or an IntlCalendar. Any IntlCalendar object passed will be clone; it will
    | not be changed by the IntlDateFormatter.
    |
    | This will determine the calendar type used (gregorian, islamic, persian, etc.) and,
    | if null is given for the timezone parameter, also the timezone used.
    |
    | Refer to the docs for more information: https://www.php.net/manual/en/intldateformatter.create.php
    |
    | Expected: IntlCalendar|int|null
    */

    'calendar' => null,

    /*
    |--------------------------------------------------------------------------
    | Date Pattern
    |--------------------------------------------------------------------------
    |
    | Optional pattern to use when formatting or parsing.
    |
    | Refer to the docs for more information: https://unicode-org.github.io/icu/userguide/format_parse/datetime/
    |
    | Expected: string
    */

    'datePattern' => '',


    /*
    |--------------------------------------------------------------------------
    | NumberFormatter Style
    |--------------------------------------------------------------------------
    |
    | Style of the formatting, one of the format style constants. If NumberFormatter::PATTERN_DECIMAL or
    | NumberFormatter::PATTERN_RULEBASED is passed then the number format is opened using the given pattern,
    | which must conform to the syntax described in » ICU DecimalFormat documentation or »
    | ICU RuleBasedNumberFormat documentation, respectively.
    |
    */

    'style' => NumberFormatter::DECIMAL,

    /*
    |--------------------------------------------------------------------------
    | Number Pattern
    |--------------------------------------------------------------------------
    |
    | Pattern string if the chosen style requires a pattern.
    |
    | Expected: string
    */

    'numberPattern' => '',

    /*
    |--------------------------------------------------------------------------
    | Number Attributes
    |--------------------------------------------------------------------------
    |
    | Set a numeric attribute associated with the formatter.
    | An example of a numeric attribute is the number of integer digits the formatter will produce.
    */

    'attributes' => [
        NumberFormatter::FRACTION_DIGITS => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Number Text Attributes
    |--------------------------------------------------------------------------
    |
    | Set a text attribute associated with the formatter. An example of a text attribute is the suffix for
    | positive numbers. If the formatter does not understand the attribute, U_UNSUPPORTED_ERROR error is
    | produced.
    |
    | Rule-based formatters only understand NumberFormatter::DEFAULT_RULESET and NumberFormatter::PUBLIC_RULESETS.
    */

    'textAttributes' => [
        NumberFormatter::POSITIVE_PREFIX => '++',
    ],
];

