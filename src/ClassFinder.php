<?php

namespace Wnx\LaravelStats;

use Symfony\Component\Finder\Finder;
use Exception;

class ClassFinder
{
    /**
     * @var Symfony\Component\Finder\Finder
     */
    protected $finder;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
        $this->findAndLoadClasses();
    }


    /**
     * Return a Collection of Declared Classes
     * Classes belonging to the Illuminate and Symfony Namespace
     * are removed from the Collection
     *
     * @return Illuminate\Support\Collection
     */
    public function getDeclaredClasses()
    {
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

    protected function findAndLoadClasses()
    {
        $this->requireClassesFromFiles(
            $this->findFilesInProject()
        );
    }

    /**
     * Require each PHP file to make them available
     * in the get_declared_classes function
     * @param  Finder $files
     * @return void
     */
    protected function requireClassesFromFiles(Finder $files)
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
    protected function findFilesInProject()
    {
        $this->finder->files()->in(base_path())->exclude([
            'app/Console',
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
