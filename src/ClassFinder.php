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
     * are removed from the Collection
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

        $filtered = $classes->reject(function($value, $key) {
            return starts_with($value, 'Illuminate'); // Ignore Illuminate Packages
        })->reject(function($value, $key) {
            return starts_with($value, 'Symfony');
        });

        return $filtered;
    }

    /**
     * Set base path
     * @param string $path
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;
    }

    protected function findAndLoadClasses() : void
    {
        $this->requireClassesFromFiles(
            $this->findFilesInProjectPath()
        );
    }

    /**
     * Require each PHP file to make them available
     * in the get_declared_classes function
     * @param  Finder $files
     * @return void
     */
    protected function requireClassesFromFiles(Finder $files) : void
    {
        foreach ($files as $file) {
            try {
                require_once $file->getRealPath();
            } catch (Exception $e) {}
        }
    }

    /**
     * Find PHP Files which should be analyzed
     * @return Finder
     */
    protected function findFilesInProjectPath() : Finder
    {
        $this->finder->files()->in($this->basePath)->exclude([
            'vendor',
            'config',
            'bootstrap',
            // 'database',
            'tests',
            'resources',
            'routes',
            'public'
        ])->name('*.php')->notName('*.blade.php')->notName('server.php');

        return $this->finder;
    }
}
