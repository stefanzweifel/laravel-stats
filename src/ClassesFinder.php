<?php declare(strict_types=1);

namespace Wnx\LaravelStats;

use Exception;
use SplFileInfo;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;

class ClassesFinder
{
    /**
     * Find PHP Files on filesystem and require them.
     * We need to use ob_* functions to ensure that
     * loaded files do not output anything.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findAndLoadClasses(): Collection
    {
        ob_start();

        $this->findFilesInProjectPath()
            ->each(function (SplFileInfo $file) {
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
     * @return \Illuminate\Support\Collection
     */
    protected function findFilesInProjectPath(): Collection
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
     * @param  \Illuminate\Support\Collection  $excludes
     *
     * @return bool
     */
    protected function isExcluded(SplFileInfo $file, Collection $excludes): bool
    {
        return $excludes->contains(function ($exclude) use ($file) {
            return Str::startsWith($file->getPathname(), $exclude);
        });
    }
}
