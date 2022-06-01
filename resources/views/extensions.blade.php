country name: {{ country_name('DZ', 'nl-BE') }}
currency name: {{ currency_name('XOF', 'nl-BE') }}
currency symbol: {{ currency_symbol('JPY') }}
language name: {{ language_name('fr_CA', 'nl-BE') }}
locale name: {{ locale_name('de', 'nl-BE') }}
timezone name: {{ timezone_name('Africa/Nairobi', 'fr_BE') }}
format number: {{ format_number(12.345, ['fraction_digit' => 4], 'spellout', 'default', 'nl-BE') }}
format currency: {{ format_currency('1000000', 'EUR', ['fraction_digit' => 4], 'de') }}
country timezones: {{ implode(', ', country_timezones('CD')) }}
