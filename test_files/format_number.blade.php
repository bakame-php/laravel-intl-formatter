{{ format_number(12.345) }}
{{ format_number(12.345, [], 'decimal', 'default', 'fr') }}
{{ format_number(12.345, [], 'percent') }}
{{ format_number(12.345, [], 'spellout') }}
{{ format_number(12.345, [], 'percent') }}
{{ format_number(12.345, [], 'spellout') }}
{{ format_number(80.345, [], 'spellout', 'default', 'fr_FR') }}
{{ format_number(80.345, [], 'spellout', 'default', 'fr_CH') }}
{{ format_number(12, [], 'duration') }}
{{ format_number(0.12, ['fraction_digit' => 1], 'percent') }}
{{ format_number(0.12345, ['rounding_mode' => 'ceiling'], 'percent') }}
