<?php

return [
    'date' => [
        /*
        |--------------------------------------------------------------------------
        | Date Type
        |--------------------------------------------------------------------------
        |
        | Date type to use (none, short, medium, long, full). This is one of the IntlDateFormatter constants.
        |
        | Refer to the docs for more information: https://www.php.net/manual/en/intldateformatter.create.php
        |
        | Expected: string
        */
        'dateType' => IntlDateFormatter::MEDIUM,
        /*
        |--------------------------------------------------------------------------
        | Time Type
        |--------------------------------------------------------------------------
        |
        | Time type to use (none, short, medium, long, full). This is one of the IntlDateFormatter constants.
        |
        | Refer to the docs for more information: https://www.php.net/manual/en/intldateformatter.create.php
        |
        | Expected: string
        */
        'timeType' => IntlDateFormatter::MEDIUM,
        /*
        |--------------------------------------------------------------------------
        | Date Pattern
        |--------------------------------------------------------------------------
        |
        | Optional pattern to use when formatting or parsing.
        |
        | Refer to the docs for more information: https://unicode-org.github.io/icu/userguide/format_parse/datetime/
        |
        | Expected: ?string
        */
        'pattern' => null,
    ],
    'number' => [
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
        | Expected: ?string
        */
        'pattern' => null,
        /*
        |--------------------------------------------------------------------------
        | Number Attributes
        |--------------------------------------------------------------------------
        |
        | Set a numeric attribute associated with the formatter.
        | An example of a numeric attribute is the number of integer digits the formatter will produce.
        |
        | Expected: array<int, int|float>
        |
        | Refer to the docs for more information: https://www.php.net/manual/en/numberformatter.setattribute.php
        */
        'attributes' => [],
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
        |
        | Expected: array<int, string>
        |
        | Refer to the docs for more information: https://www.php.net/manual/en/numberformatter.settextattribute.php
        */
        'textAttributes' => [],
        /*
        |--------------------------------------------------------------------------
        | Symbol Attributes
        |--------------------------------------------------------------------------
        |
        | Set a symbol associated with the formatter. The formatter uses symbols to represent the special
        | locale-dependent characters in a number, for example the percent sign. This API is not supported
        | for rule-based formatters.
        |
        | Expected: array<int, string>
        |
        | Refer to the docs for more information: https://www.php.net/manual/en/numberformatter.setsymbol.php
        */
        'symbolAttributes' => [],
    ],
];
