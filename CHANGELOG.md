# Changelog

All Notable changes to `bakame/laravel-intl-formatter` will be documented in this file

## [0.3.0] - 2022-06-14

### Added

- Support for `Money` package.
- Added `IntlFactory` facade.
- `NumberFactory` and `DateFactory` are now accessible as readonly property of the `Factory` class.

### Fixed

- **[BC Break]** Renamed `Factory::newInstance` in `Factory::newFormatter`
- **[BC Break]** Keys used for container registration are updated.

### Deprecated

- None

### Removed

**[BC Break]** `Factory::newInstance` replaced by `Factory::newFormatter`

## [0.2.0] - 2022-06-06

** Dependencies fixes

## [0.1.0] - 2022-06-04

**Initial release!**

[Next]: https://github.com/bakame-php/laravel-intl-formatter/compare/0.3.0...main
[Next]: https://github.com/bakame-php/laravel-intl-formatter/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/bakame-php/laravel-intl-formatter/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/bakame-php/laravel-intl-formatter/releases/tag/0.1.0
