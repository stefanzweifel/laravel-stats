# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/stefanzweifel/laravel-stats/compare/v2.2.0...HEAD)

> TBD

## [v2.2.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.1.1...v2.2.0) - 2020-04-04

### Added
- Add Blade Components Classifier [#169](https://github.com/stefanzweifel/laravel-stats/issues/169), [#173](https://github.com/stefanzweifel/laravel-stats/pull/173)
- Add Custom Casts Classifier [#168](https://github.com/stefanzweifel/laravel-stats/issues/168), [#174](https://github.com/stefanzweifel/laravel-stats/pull/174)


## [v2.1.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.1.0...v2.1.1) - 2020-03-03

### Removed
- Drop support for `phpunit` `8.0`

## [v2.1.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.0.2...v2.1.0) - 2020-03-03

Note: Due to underlying changes to the `phploc`-dependency, the numbers for "loc" and "lloc" in your project may change.

### Changed
- Run test suite against Laravel 7 [#170](https://github.com/stefanzweifel/laravel-stats/pull/170)

### Removed
- Removed support to detect `Illuminate\Http\Resources\Json\Resource` as an API resource [#170](https://github.com/stefanzweifel/laravel-stats/pull/170)
- Dropped support for Laravel 5.8 [#170](https://github.com/stefanzweifel/laravel-stats/pull/170)
- Dropped support for Laravel 6.0 [#170](https://github.com/stefanzweifel/laravel-stats/pull/170)
- Dropped support for PHP 7.2 [#170](https://github.com/stefanzweifel/laravel-stats/pull/170)

## [v2.0.2](https://github.com/stefanzweifel/laravel-stats/compare/v2.0.1...v2.0.2) - 2020-02-22

### Changed
- Changed Version Contraints for `phploc/phploc` to support `6.0` [#167](https://github.com/stefanzweifel/laravel-stats/pull/167)


## [v2.0.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.0.0...v2.0.1) - 2020-02-18

## Added
- Add Laravel Nova Dashboard Classifier [#158](https://github.com/stefanzweifel/laravel-stats/pull/158), [#159](https://github.com/stefanzweifel/laravel-stats/pull/159)
- Add `php-cs-fixer` GitHub Actions workflow [#160](https://github.com/stefanzweifel/laravel-stats/pull/160)

### Changed
- Test Package against Laravel 6.0 [#155](https://github.com/stefanzweifel/laravel-stats/pull/155)
- Set `declare(strict_types=1)` everywhere [#161](https://github.com/stefanzweifel/laravel-stats/pull/161)
- Changed Version Contraints in composer.json to support Laravel 7.0
- Changed Version Contraints for `phpunit/phpunit` to support `9.0`

### Fixed
- Make `ControllerClassifier` compatible with Lumen 6.0 [2462fe](https://github.com/stefanzweifel/laravel-stats/commit/2462fe1c597bcc8b39190dedf511ab60a8935fea)
- Fix an Issue in `ResourceClassifier` where not all kinds of Resources were correctly identified as API Resources [#156](https://github.com/stefanzweifel/laravel-stats/pull/156)


## [v2.0.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.9.2...v2.0.0) - 2019-09-01

Checkout the [Release and Upgrade Guide](https://github.com/stefanzweifel/laravel-stats/releases/tag/v2.0.0) for more.

### Added
- Add Verbose Mode
- Add ability to filter output by one or multiple component names

### Changed
- Rename `getName()` to `name()` [#147](https://github.com/stefanzweifel/laravel-stats/pull/147)
- Rename "LOC" to "LLOC" [#148](https://github.com/stefanzweifel/laravel-stats/pull/148)
- Refactored Internal Classes [#150](https://github.com/stefanzweifel/laravel-stats/pull/150)
    + Move some of the logic from `ComponentFinder` to `ClassesFinder`
    + Update `Classifier`-contract and update existing Classifiers to implement new contract
    + Move tests for each existing Classifier into their own test files

### Removed
- Drop support for Laravel 5.5, Lumen 5.5 and PHP 7.0 [#133](https://github.com/stefanzweifel/laravel-stats/pull/133)
- Drop support for Laravel 5.6, 5.7 and PHP 7.1 [#151](https://github.com/stefanzweifel/laravel-stats/pull/151)

## [v1.9.2](https://github.com/stefanzweifel/laravel-stats/compare/v1.9.1...v1.9.2) - 2019-03-20

### Added

- Add additional support to detect Route Middlewares [#140](https://github.com/stefanzweifel/laravel-stats/pull/140)


## [v1.9.1](https://github.com/stefanzweifel/laravel-stats/compare/v1.9.0...v1.9.1) - 2019-03-18

### Fixes

- Fix compatibility issues with Lumen [#139](https://github.com/stefanzweifel/laravel-stats/pull/139)

## [v1.9.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.8.3...v1.9.0) - 2019-03-17

### Added

- Add Number of Routes to Statistics [#136](https://github.com/stefanzweifel/laravel-stats/pull/136)

## [v1.8.3](https://github.com/stefanzweifel/laravel-stats/compare/v1.8.2...v1.8.3) - 2019-03-16

### Changed

- Update phploc version contstraint to support PHP7.3 [#129](https://github.com/stefanzweifel/laravel-stats/pull/129)

## [v1.8.2](https://github.com/stefanzweifel/laravel-stats/compare/v1.8.1...v1.8.2) - 2019-03-06

### Fixes
- Fixes an Issue where a thrown Exception stopped the `stats` command [#134](https://github.com/stefanzweifel/laravel-stats/pull/134)

## [v1.8.1](https://github.com/stefanzweifel/laravel-stats/compare/v1.8.0...v1.8.1) - 2019-02-26

### Changed
- Changed Version Contraints in `composer.json` to support Laravel 5.8 [#132](https://github.com/stefanzweifel/laravel-stats/pull/132)
- Replace `str_contains()` and `starts_with()` helper with `Str::contains()` and `Str::startsWith()` [#130](https://github.com/stefanzweifel/laravel-stats/pull/130)
- Update `laravel/browser-kit-testing` dependency [#131](https://github.com/stefanzweifel/laravel-stats/pull/131)

## [v1.8.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.7.2...v1.8.0) - 2018-10-20

### Added
- Add Support for Laravel Nova Components [#127](https://github.com/stefanzweifel/laravel-stats/pull/127)

### Changed
- Automatically test package against multiple Laravel Versions [#126](https://github.com/stefanzweifel/laravel-stats/pull/126)

## [v1.7.2](https://github.com/stefanzweifel/laravel-stats/compare/v1.7.1...v1.7.2) - 2018-08-24

### Changed
- Changed Version Contraints in `composer.json` to support Laravel 5.7 [#125](https://github.com/stefanzweifel/laravel-stats/pull/125)

## [v1.7.1](https://github.com/stefanzweifel/laravel-stats/compare/v1.7.0...v1.7.1) - 2018-04-16

### Changed

- Prevent the `Classifier`-class from throwing Exceptions [#122](https://github.com/stefanzweifel/laravel-stats/pull/122)

## [v1.7.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.6.1...v1.7.0) - 2018-03-30

### Added

- Added Support for Lumen [#121](https://github.com/stefanzweifel/laravel-stats/pull/121)

## [v1.6.1](https://github.com/stefanzweifel/laravel-stats/compare/v1.6.0...v1.6.1) - 2018-02-07

### Changed

- Changed Version Contraints for `laravel/dusk` to support `~2.0` and `~3.0`

## [v1.6.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.5.0...v1.6.0) - 2018-02-07

### Changed

- Changed Version Contraints in `composer.json` to support Laravel 5.6

## [v1.5.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.4.0...v1.5.0) - 2018-02-05

### Added

- Add new Feature: Custom Components in [#115](https://github.com/stefanzweifel/laravel-stats/pull/115)
- Add new Feature: JSON Output in [#116](https://github.com/stefanzweifel/laravel-stats/pull/116)

## [v.1.4.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.3.3...v1.4.0) - 2017-12-01

### Added

- Add new config `rejection_strategy` in [#112](https://github.com/stefanzweifel/laravel-stats/pull/112)
- Add new config `ignored_namespaces` in [#113](https://github.com/stefanzweifel/laravel-stats/pull/113)

## [v.1.3.3](https://github.com/stefanzweifel/laravel-stats/compare/v1.3.2...v1.3.3) - 2017-11-14

### Changed

- Enable `tests`-folder in config file by default (Previous issue with testsuite has been fixed in [eaedc4](https://github.com/stefanzweifel/laravel-stats/commit/eaedc4dee84043a985b0cf7d337cf7b479b62a75))

## [v.1.3.2](https://github.com/stefanzweifel/laravel-stats/compare/v1.3.1...v1.3.2) - 2017-11-13

### Changed

- Update Sorting of output table (Components are sorted by name; Tests are always at the bottom)

## [v.1.3.1](https://github.com/stefanzweifel/laravel-stats/compare/v1.3.0...v1.3.1) - 2017-11-10

### Changed

- Update Sorting so Tests are at the bottom of the output table [#110](https://github.com/stefanzweifel/laravel-stats/pull/110)

## [v.1.3.0](https://github.com/stefanzweifel/laravel-stats/compare/v1.2.1...v1.3.0) - 2017-11-05

### Added

- Show Code to Test Ratio at the bottom of the summary table [#109](https://github.com/stefanzweifel/laravel-stats/pull/109)

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
