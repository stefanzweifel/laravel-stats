# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`wnx/laravel-stats` is a **dev-only Composer package** (not an application) that adds a `php artisan stats` Artisan command to Laravel projects. It scans a host project's classes, classifies each one as a Laravel component type (Controller, Model, Job, etc.), and reports line/method counts grouped by component.

The package ships no runtime app code — everything lives under `src/` and is exercised through `orchestra/testbench`, which boots a throwaway Laravel app in the test suite.

## Commands

```bash
composer test                 # Run the full PHPUnit suite
vendor/bin/phpunit --filter=ControllerClassifierTest   # Run a single test class
vendor/bin/phpunit tests/Classifiers/ControllerClassifierTest.php   # Run a single test file

composer format               # Apply php-cs-fixer (PSR-2 + short arrays + declare_strict_types + no unused imports)
vendor/bin/phpstan analyse    # Larastan level 5 over src/ (config in phpstan.neon)
vendor/bin/rector process     # Apply rector rules (PHP 8.2 sets, dead-code, PHPUnit 10)
```

Requirements: PHP `^8.4`, Laravel `^12 | ^13`, Testbench `^10 | ^11`. CI matrix tests PHP 8.4/8.5 × Laravel 12/13 × prefer-lowest/prefer-stable.

Tests use PHPUnit `#[Test]` attributes (not `@test` annotations or Pest). All test classes extend `Wnx\LaravelStats\Tests\TestCase`, which extends `Orchestra\Testbench\TestCase`.

## Architecture

The `stats` command (`src/Console/StatsListCommand.php`) runs a pipeline:

1. **`ClassesFinder`** — uses Symfony Finder to locate `*.php` files in the host project's `stats.paths` config, `require_once`s them (wrapped in `ob_*` to swallow output), then returns `get_declared_classes()`. Pest test files are heuristically detected and skipped — requiring them throws, so Pest tests **cannot** be classified (a known limitation).
2. **Filtering** (in the command) — each class is wrapped in a `ReflectionClass`, then rejected by (a) the configured `RejectionStrategy` (`RejectVendorClasses` by default, or `RejectInternalClasses`), (b) deduped by filename, and (c) dropped if its namespace matches `stats.ignored_namespaces`. Anonymous migrations (`Migration@anonymous`) are always kept.
3. **`Project`** — classifies each surviving `ReflectionClass` into a `ClassifiedClass` and provides grouping helpers used by the outputs.
4. **`Classifier`** — the dispatcher. It walks `Classifier::DEFAULT_CLASSIFIER` (plus any `stats.custom_component_classifier` entries) in order and returns the **first** classifier whose `satisfies()` returns true; falls back to `NullClassifier`. **Order matters** — e.g. `LivewireComponentClassifier` runs before `ControllerClassifier` because Livewire components would otherwise match as controllers.
5. **Outputs** — `AsciiTableOutput` (default) or `JsonOutput` (`--json`), both honoring `--verbose` and `--components=`.

### `src/ReflectionClass.php`

A thin wrapper around PHP's native `ReflectionClass` plus the `stefanzweifel/laravel-stats-phploc` package. This is what all classifiers receive and what computes line/method counts. Use its helpers (`isSubclassOf`, `usesTrait`, `getName`, `getNamespaceName`, etc.) rather than native reflection.

### Classifiers (`src/Classifiers/`)

Each classifier implements `Wnx\LaravelStats\Contracts\Classifier`:

- `name()` — display label (e.g. `"Controllers"`)
- `satisfies(ReflectionClass $class): bool` — whether the class is this component type
- `countsTowardsApplicationCode()` / `countsTowardsTests()` — which totals it contributes to

Detection strategies vary: most check inheritance/traits (`ModelClassifier` → extends `Eloquent\Model`), but some inspect **runtime registrations** — `ControllerClassifier` matches against the router's registered routes, `MiddlewareClassifier`/`PolicyClassifier`/`EventListenerClassifier` inspect the HTTP kernel and service providers. Because of this, classifiers rely on the booted Laravel app; exceptions thrown inside `satisfies()` are caught and treated as "not satisfied".

**To add a new built-in component type:** create a classifier in `src/Classifiers/`, register it in `Classifier::DEFAULT_CLASSIFIER` (mind ordering vs. more general classifiers), add a stub under `tests/Stubs/`, and add a test under `tests/Classifiers/`.

## Test stubs

`tests/Stubs/` holds one directory per component type with sample classes that classifiers are tested against. Nova classes live in a separate `test-stubs-nova/` autoloaded under the `Laravel\Nova\` namespace (Nova isn't a real dependency). Stub directories are excluded from php-cs-fixer.
