<?php

namespace Wnx\LaravelStats;

use Exception;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;

class ClassFinder
{
    /**
     * @var Symfony\Component\Finder\Finder
     */
    protected $finder;

    /**
     * @var string
     */
    protected $basePath;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;

        // Set default base path to look for classes
        $this->basePath = base_path();
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
     * Set base path.
     *
     * @param string $path
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;
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
     * @param Finder $files
     *
     * @return void
     */
    protected function requireClassesFromFiles(Finder $files)
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
     * @return Finder
     */
    public function findFilesInProjectPath() : Finder
    {
        return $this->finder->files()
            ->in(config('stats.path', []))
            ->name('*.php');
    }
}
