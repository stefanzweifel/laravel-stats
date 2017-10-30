# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/stefanzweifel/laravel-stats/compare/v1.2.0...HEAD)

## [v.1.2.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.1.1...v1.2.0) - 2017-10-30

### Added

- Add Event Listener Classifier [#108](https://github.com/stefanzweifel/laravel-stats/pull/108)

### Changed

- Refactor Internals to allow JsonOutput in the future [#99](https://github.com/stefanzweifel/laravel-stats/pull/99), [#102](https://github.com/stefanzweifel/laravel-stats/pull/102)

## [v.1.1.1](https://github.com/stefanzweifel/laravel-stats/compare/v1.1.0...v1.1.1) - 2017-10-24

### Fixed

- Fix an Issue with Test Classifiers if the dependency was not installed in a project [1b65909e](https://github.com/stefanzweifel/laravel-stats/commit/1b65909ee54644a96b67571518f9fefad3ea2e0f)

## [v1.1.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.0.0...v1.1.0) - 2017-10-24

- Add PHPUnit Classifier [#89](https://github.com/stefanzweifel/laravel-stats/pull/89)
- Add Laravel Dusk Classifier [#86](https://github.com/stefanzweifel/laravel-stats/pull/86)
- Add Laravel Browser Kit Classifier [#95](https://github.com/stefanzweifel/laravel-stats/pull/95)

## [v.1.0.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.0.0-beta-2...v1.0.0) - 2017-10-19

### Added

- Classify non Laravel Classes as "Other" [#74](https://github.com/stefanzweifel/laravel-stats/pull/74)

### Changed

- Stats Numbers are now right aligned [3553409e](https://github.com/stefanzweifel/laravel-stats/commit/3553409e193e19930d1acef43ccf6ce6c2f4fb43)

## [v1.0.0-beta-2](https://github.com/stefanzweifel/laravel-stats/compare/v1.0.0-beta...v1.0.0-beta-2) - 2017-10-17

### Added

- Detect Policies [#18](https://github.com/stefanzweifel/laravel-stats/pull/18)
- Detect Middlewares [#28](https://github.com/stefanzweifel/laravel-stats/pull/28)

### Changed

- Add support for PHP 7.0 [#22](https://github.com/stefanzweifel/laravel-stats/pull/22)
- Changed config file [#36](https://github.com/stefanzweifel/laravel-stats/pull/36), [#42](https://github.com/stefanzweifel/laravel-stats/pull/42)
- A component is recognized by a Classifier [#62](https://github.com/stefanzweifel/laravel-stats/pull/62)

## [v1.0.0-beta](https://github.com/stefanzweifel/laravel-stats/releases/tag/v1.0.0-beta) - 2017-10-08

### Added

- Add support to identify a class as a Laravel "Component"
- Add support to ignore certain folders and files through a config file
- Add `ComponentSort` to sort declared classes into `Component`
- Add Statistics Classes to retrieve number of classes, methods and lines of code
