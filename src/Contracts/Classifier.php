<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Contracts;

use Wnx\LaravelStats\ReflectionClass;

interface Classifier
{
    /**
     * Component Name displayed in the results.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Determine if the given ReflectionClass should be classified
     * as the component the Classifier Class represents.
     *
     * @param \Wnx\LaravelStats\ReflectionClass $class
     *
     * @return bool
     */
    public function satisfies(ReflectionClass $class): bool;

    /**
     * Determine if the lines of code of the component should count towards
     * the total number of lines of code of the application.
     *
     * @return bool
     */
    public function countsTowardsApplicationCode(): bool;

    /**
     * Determine if the lines of code of the component should count towards
     * the total number of lines of code of the test suite.
     *
     * @return bool
     */
    public function countsTowardsTests(): bool;
}
