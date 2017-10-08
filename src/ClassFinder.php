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
     * Classes belonging to the Illuminate and Symfony Namespace
     * are removed from the Collection.
     *
     * @return Illuminate\Support\Collection
     */
    public function getDeclaredClasses() : Collection
    {
        $this->findAndLoadClasses();
        // We should filter out common classes
        // - std_class
        // - ? Exception
        $classes = collect(get_declared_classes());

        $filtered = $classes->reject(function ($value, $key) {
            return starts_with($value, 'Illuminate'); // Ignore Illuminate Packages
        })->reject(function ($value, $key) {
            return starts_with($value, 'Symfony');
        })->reject(function ($class) {
            return (new ReflectionClass($class))->isNative();
        });

        return $filtered;
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
    protected function findAndLoadClasses() : void
    {
        $this->requireClassesFromFiles(
            $this->findFilesInProjectPath()
        );
    }

    /**
     * Require each PHP file to make them available
     * in the get_declared_classes function.
     *
     * @param Finder $files
     *
     * @return void
     */
    protected function requireClassesFromFiles(Finder $files) : void
    {
        $filesToIgnore = collect($this->getFilesToIgnore());

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
    protected function findFilesInProjectPath() : Finder
    {
        $excludedFolders = $this->getFoldersToIgnore();

        $this->finder->files()
            ->in($this->basePath)
            ->exclude($excludedFolders)
            ->name('*.php');

        foreach ($this->getFilesToIgnore() as $filename) {
            $this->finder->notName($filename);
        }

        return $this->finder;
    }

    /**
     * Get an array of folder paths in which we shouldn't search for files.
     *
     * @return array
     */
    protected function getFoldersToIgnore() : array
    {
        $defaultIgnoredFolders = [
            'bootstrap',
            'config',
            'public',
            'resources',
            'routes',
            'storage',
            'tests',
            'vendor',
        ];

        $customIgnoredFolders = config('laravel-stats.ignore.folders');

        return array_merge($defaultIgnoredFolders, $customIgnoredFolders);
    }

    /**
     * Get an array of file paths and names which should be ignored.
     *
     * @return array
     */
    protected function getFilesToIgnore() : array
    {
        $defaultFilesToIgnore = [
            '*.html',
            '*twig*',
            '*.blade.php',
            'blade.php',
            'server.php',
        ];

        $customIgnoredFiles = config('laravel-stats.ignore.files');

        return array_merge($defaultFilesToIgnore, $customIgnoredFiles);
    }
}
