{{ format_currency(1000000, 'EUR') }}
{{ format_currency(1000000, 'EUR', 'de', []) }}
{{ format_currency(1000000, 'EUR', null, ['fraction_digit' => 2]) }}
{{ format_currency(12.345, 'EUR', null, ['rounding_mode' => 'floor']) }}
{{ format_currency(125000, 'YEN') }}
{{ format_currency(\Money\Money::EUR(1234), null, null, ['rounding_mode' => 'floor']) }}
