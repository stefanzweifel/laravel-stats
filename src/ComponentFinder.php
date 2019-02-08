<?php

namespace Wnx\LaravelStats;

use Exception;
use SplFileInfo;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses;

class ComponentFinder
{
    /**
     * @var RejectionStrategy
     */
    protected $rejectionStrategy;

    public function __construct()
    {
        $rejectionStrategy = config('stats.rejection_strategy', RejectVendorClasses::class);

        $this->rejectionStrategy = app($rejectionStrategy);
    }

    /**
     * Scan the Project for PHP Classes, turn them into ReflectionClasses,
     * reject unwanted Classes and sort them into Components.
     *
     * @return Collection
     */
    public function get()
    {
        return $this->findAndLoadClasses()
            ->map(function ($class) {
                return new ReflectionClass($class);
            })
            ->reject(function ($class) {
                return $this->rejectionStrategy->shouldClassBeRejected($class);
            })
            ->reject(function ($class) {
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
     * @return Collection
     */
    protected function findAndLoadClasses()
    {
        ob_start();

        $this->findFilesInProjectPath()
            ->each(function ($file) {
                try {
                    require_once $file->getRealPath();
                } catch (Exception $e) {
                }
            });

        ob_end_clean();

        return collect(get_declared_classes());
    }

    /**
     * Find PHP Files which should be analyzed.
     *
     * @return Collection
     */
    protected function findFilesInProjectPath() : Collection
    {
        $excludes = collect(config('stats.exclude', []));

        $files = (new Finder)->files()
            ->in(config('stats.paths', []))
            ->name('*.php');

        return collect($files)
            ->reject(function ($file) use ($excludes) {
                return $this->isExcluded($file, $excludes);
            });
    }

    /**
     * Determine if a file has been defined in the exclude configuration.
     *
     * @param  SplFileInfo $file
     * @param  Collection  $excludes
     * @return bool
     */
    protected function isExcluded(SplFileInfo $file, Collection $excludes)
    {
        return $excludes->contains(function ($exclude) use ($file) {
            return Str::startsWith($file->getPathname(), $exclude);
        });
    }
}
