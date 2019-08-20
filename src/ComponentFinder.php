<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses;

class ComponentFinder
{
    /**
     * @var \Wnx\LaravelStats\Contracts\RejectionStrategy
     */
    protected $rejectionStrategy;

    public function __construct()
    {
        $this->rejectionStrategy = app(config('stats.rejection_strategy', RejectVendorClasses::class));
    }

    /**
     * Scan the Project for PHP Classes, turn them into ReflectionClasses,
     * reject unwanted Classes and sort them into Components.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(): Collection
    {
        return $this->findAndLoadClasses()
            ->map(function ($class) {
                return new ReflectionClass($class);
            })
            ->reject(function (ReflectionClass $class) {
                return $this->rejectionStrategy->shouldClassBeRejected($class);
            })
            ->reject(function (ReflectionClass $class) {
                foreach (config('stats.ignored_namespaces', []) as $namespace) {
                    if (Str::startsWith($class->getNamespaceName(), $namespace)) {
                        return true;
                    }
                }

                return false;
            })
            ->groupBy(function ($class) {
                return (new Classifier)->classify($class);
            });
    }

    /**
     * Find PHP Files on filesystem and require them.
     * We need to use ob_* functions to ensure that
     * loaded files do not output anything.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function findAndLoadClasses(): Collection
    {
        return app(ClassesFinder::class)->findAndLoadClasses();
    }
}
