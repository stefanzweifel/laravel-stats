# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/stefanzweifel/laravel-stats/compare/v2.16.0...HEAD)

> TBD

## [v2.16.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.15.0...v2.16.0) - 2025-08-21

### Added

- Add Pest v4 Support ([#232](https://github.com/stefanzweifel/laravel-stats/pull/232))

## [v2.15.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.14.0...v2.15.0) - 2025-02-14

### Changed

- Add Support for Laravel 12 ([#230](https://github.com/stefanzweifel/laravel-stats/pull/230))

## [v2.14.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.13.2...v2.14.0) - 2024-11-13

### Added

- Add Support for PHP 8.4 ([#229](https://github.com/stefanzweifel/laravel-stats/pull/229))

### Changed

- Add Larastan / PHPStan ([#228](https://github.com/stefanzweifel/laravel-stats/pull/228))
- Drop Support for Laravel Versions below 11 and below PHP 8.2 ([#227](https://github.com/stefanzweifel/laravel-stats/pull/227))

## [v2.13.2](https://github.com/stefanzweifel/laravel-stats/compare/v2.13.1...v2.13.2) - 2024-02-28

### Changed

- Sort Files when statistics is shown in Verbose Mode ([#226](https://github.com/stefanzweifel/laravel-stats/pull/226))
- Refactor Codebase to use modern PHP features using Rector ([#225](https://github.com/stefanzweifel/laravel-stats/pull/225))

## [v2.13.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.13.0...v2.13.1) - 2024-02-15

### Changed

- Remove calls to getLaravelVersion() for versions no longer supported ([#224](https://github.com/stefanzweifel/laravel-stats/pull/224))

### Fixed

- Fix Middleware Classifier for Laravel 11 ([#223](https://github.com/stefanzweifel/laravel-stats/pull/223))

## [v2.13.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.12.0...v2.13.0) - 2024-02-03

### Added

- Add Support for Laravel 11 ([#222](https://github.com/stefanzweifel/laravel-stats/pull/222))

## [v2.12.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.11.4...v2.12.0) - 2023-10-16

### Added

- Add Support for PHP 8.3 ([#221](https://github.com/stefanzweifel/laravel-stats/pull/221))

## [v2.11.4](https://github.com/stefanzweifel/laravel-stats/compare/v2.11.3...v2.11.4) - 2023-08-28

### Fixed

- Fix Laravel 10 bug in stats list command. ([#220](https://github.com/stefanzweifel/laravel-stats/pull/220))

## [v2.11.3](https://github.com/stefanzweifel/laravel-stats/compare/v2.11.2...v2.11.3) - 2023-08-12

### Fixed

- Ignore Pest Files when finding and loading Classes ([#219](https://github.com/stefanzweifel/laravel-stats/pull/219))

## [v2.11.2](https://github.com/stefanzweifel/laravel-stats/compare/v2.11.1...v2.11.2) - 2023-03-18

### Fixed

- Switch to forked phploc package and add support for Laravel 10 / PHPUnit 10 ([#217](https://github.com/stefanzweifel/laravel-stats/pull/217))

## [v2.11.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.11.0...v2.11.1) - 2023-03-16

### Changed

- Add Support for PhpUnit 10 ([#215](https://github.com/stefanzweifel/laravel-stats/pull/215))

## [v2.11.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.10.0...v2.11.0) - 2023-01-28

### Added

- Add Support for Laravel 10 ([#213](https://github.com/stefanzweifel/laravel-stats/pull/213))

### Changed

- Drop Support for Laravel 7 &  Laravel 8 ([#212](https://github.com/stefanzweifel/laravel-stats/pull/212))
- Drop Support for PHP 7.3 & PHP 7.4 ([#212](https://github.com/stefanzweifel/laravel-stats/pull/212))

## [v2.10.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.9.2...v2.10.0) - 2022-10-29

### Added

- Add Support for PHP 8.2 ([#210](https://github.com/stefanzweifel/laravel-stats/pull/210))

## [v2.9.2](https://github.com/stefanzweifel/laravel-stats/compare/v2.9.1...v2.9.2) - 2022-07-05

### Fixed

- Fix Issue with Anonymous Database Migrations ([#208](https://github.com/stefanzweifel/laravel-stats/pull/208))

## [v2.9.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.9.0...v2.9.1) - 2022-05-31

### Fixed

- Fix Issue with running `stats` with Laravel Sail and Swoole extension installed ([#207](https://github.com/stefanzweifel/laravel-stats/pull/207))

## [v2.9.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.8.1...v2.9.0) - 2022-03-22

## Deprecated

- Deprecate `--share` option ([#205](https://github.com/stefanzweifel/laravel-stats/pull/205))

## [v2.8.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.8.0...v2.8.1) - 2022-02-22

## Fixed

- Fix EventListenerClassifier and add EventSubscribers Test ([#204](https://github.com/stefanzweifel/laravel-stats/pull/204))

## [v2.8.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.7.0...v2.8.0) - 2022-01-19

## Added

- Add Support for Laravel 9 ([#202](https://github.com/stefanzweifel/laravel-stats/pull/202))

## [v2.7.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.6.0...v2.7.0) - 2021-11-26

## Added

- Add Livewire Component classifier ([#201](https://github.com/stefanzweifel/laravel-stats/pull/201))

## [v2.6.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.5.2...v2.6.0) - 2021-11-20

## Added

- Add Support for PHP 8.1 ([#198](https://github.com/stefanzweifel/laravel-stats/pull/198))

## Removed

- Drop Support for Laravel 6 ([#200](https://github.com/stefanzweifel/laravel-stats/pull/200))

## [v2.5.2](https://github.com/stefanzweifel/laravel-stats/compare/v2.5.1...v2.5.2) - 2021-05-02

## Fixes

- Update config to exclude `Swoole` namespace when running `stats` command. (Fixes Issue when running `stats` in a Laravel Octane Application) [#196](https://github.com/stefanzweifel/laravel-stats/pull/196)

## [v2.5.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.5.0...v2.5.1) - 2021-03-11

### Fixes

- Fix `stats` command when run in projects which is using Closure based Event Listeners in Models `booted` method. [#193](https://github.com/stefanzweifel/laravel-stats/pull/193)

## [v2.5.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.4.1...v2.5.0) - 2020-11-20

### Added

- Support for PHP 8 [#187](https://github.com/stefanzweifel/laravel-stats/pull/187)

## [v2.4.1](https://github.com/stefanzweifel/laravel-stats/compare/v2.4.0...v2.4.1) - 2020-09-29

### Changed

- Use latest version of `stefanzweifel/laravel-stats-phploc` (Remove deprecated `sebastian/finder-facade` dependency) [#185](https://github.com/stefanzweifel/laravel-stats/pull/185), [#184](https://github.com/stefanzweifel/laravel-stats/issues/184)

## [v2.4.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.3.0...v2.4.0) - 2020-09-08

### Added

- Add Database Factory Classifier [#183](https://github.com/stefanzweifel/laravel-stats/pull/183)
- Add Support for Laravel 8 [#180](https://github.com/stefanzweifel/laravel-stats/pull/180)

## [v2.3.0](https://github.com/stefanzweifel/laravel-stats/compare/v2.2.0...v2.3.0) - 2020-09-01

### Added

- Add Observer Classifier [#177](https://github.com/stefanzweifel/laravel-stats/pull/177), [#128](https://github.com/stefanzweifel/laravel-stats/issues/128)
- Add `--share` option [#178](https://github.com/stefanzweifel/laravel-stats/pull/178)

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
  
- - Move some of the logic from `ComponentFinder` to `ClassesFinder`
  
- 
- 
- 
- 
- 
- 
- 
- 
- 
- 
- - Update `Classifier`-contract and update existing Classifiers to implement new contract
  
- 
- 
- 
- 
- 
- 
- 
- 
- 
- 
- - Move tests for each existing Classifier into their own test files
  
- 
- 
- 
- 
- 
- 
- 
- 
- 
- 
- 

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
