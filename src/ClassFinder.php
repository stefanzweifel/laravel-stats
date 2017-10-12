<?php

namespace Wnx\LaravelStats;

use Exception;
use SplFileInfo;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;

class ClassFinder
{
    /**
     * @var Symfony\Component\Finder\Finder
     */
    protected $finder;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Return a Collection of Declared Classes
     * Classes that belong to the Illuminate and Symfony Namespace
     * are removed from the Collection.
     *
     * @return Illuminate\Support\Collection
     */
    public function getDeclaredClasses() : Collection
    {
        return $this->findAndLoadClasses()
            ->reject(function ($class) {
                return (new ReflectionClass($class))->isNative();
            })
            ->reject(function ($class) {
                return (new ReflectionClass($class))->isVendorProvided();
            });
    }

    /**
     * Find PHP Files on filesystem and require them.
     *
     * @return void
     */
    protected function findAndLoadClasses()
    {
        $this->requireClassesFromFiles(
            $this->findFilesInProjectPath()
        );

        return collect(get_declared_classes());
    }

    /**
     * Require each PHP file to make them available
     * in the get_declared_classes function.
     *
     * @param Collection $files
     *
     * @return void
     */
    protected function requireClassesFromFiles(Collection $files)
    {
        foreach ($files as $file) {
            try {
                require_once $file->getRealPath();
            } catch (Exception $e) {
            }
        }
    }

    /**
     * Find PHP Files which should be analyzed.
     *
     * @return Collection
     */
    public function findFilesInProjectPath() : Collection
    {
        $excludes = collect(config('stats.exclude', []));

        $files = $this->finder->files()
            ->in(config('stats.paths', []))
            ->name('*.php');

        return collect($files)
            ->reject(function ($file) use ($excludes) {
                return $this->isExcluded($file, $excludes);
            });
    }

    protected function isExcluded(SplFileInfo $file, Collection $excludes)
    {
        return $excludes->contains(function ($exclude) use ($file) {
            return starts_with($file->getPathname(), $exclude);
        });
    }
}
