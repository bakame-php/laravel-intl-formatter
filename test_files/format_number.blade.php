{{ format_number(12.345) }}
{{ format_number(12.345, 'fr', 'default', [], 'decimal') }}
{{ format_number(12.345, null, 'default', [], 'percent') }}
{{ format_number(12.345, null, 'default', [], 'spellout') }}
{{ format_number(12.345, null, 'default', [], 'percent') }}
{{ format_number(12.345, null, 'default', [], 'spellout') }}
{{ format_number(80.345, 'fr_FR', 'default', [], 'spellout') }}
{{ format_number(80.345, 'fr_CH', 'default', [], 'spellout') }}
{{ format_number(12, null, 'default', [], 'duration') }}
{{ format_number(0.12, null, 'default', ['fraction_digit' => 1], 'percent') }}
{{ format_number(0.12345, null, 'default', ['rounding_mode' => 'ceiling'], 'percent') }}
