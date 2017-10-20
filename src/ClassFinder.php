<?php

namespace Wnx\LaravelStats;

use Exception;
use SplFileInfo;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use Wnx\LaravelStats\Classifiers\Classifier;

class ClassFinder
{
    /**
     * Sort classes into Laravel Component.
     *
     * @param array $classes
     *
     * @return Collection
     */
    public function getComponents()
    {
        return $this->findAndLoadClasses()
            ->map(function ($class) {
                return new ReflectionClass($class);
            })
            ->reject(function ($class) {
                return $class->isInternal() || $class->isVendorProvided();
            })
            ->groupBy(function ($class) {
                return (new Classifier)->classify($class);
            })
            ->map(function ($classes, $name) {
                return new Component($name, $classes);
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
            return starts_with($file->getPathname(), $exclude);
        });
    }
}
