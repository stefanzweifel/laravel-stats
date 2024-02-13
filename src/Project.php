<?php declare(strict_types=1);

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Statistics\ProjectStatistic;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class Project
{
    /**
     * Collection of ReflectionClasses.
     *
     * @var \Illuminate\Support\Collection <\Wnx\LaravelStats\ReflectionClass>
     */
    private $classes;

    /**
     * Collection of ClassifiedClasses.
     *
     * @var \Illuminate\Support\Collection <\Wnx\LaravelStats\ValueObjects\ClassifiedClass>
     */
    private $classifiedClasses;

    public function __construct(Collection $classes)
    {
        $this->classes = $classes;

        // Loop through ReflectionClasses and classify them.
        $this->classifiedClasses = $this->classes->map(fn (ReflectionClass $reflectionClass) => new ClassifiedClass(
            $reflectionClass,
            app(Classifier::class)->getClassifierForClassInstance($reflectionClass)
        ));
    }

    public function classifiedClasses(): Collection
    {
        return $this->classifiedClasses;
    }

    public function classifiedClassesGroupedByComponentName(): Collection
    {
        return $this->classifiedClasses()
            ->groupBy(fn (ClassifiedClass $classifiedClass) => $classifiedClass->classifier->name())
            ->sortBy(fn ($_, string $componentName) => $componentName);
    }

    public function classifiedClassesGroupedAndFilteredByComponentNames(array $componentNamesToFilter = []): Collection
    {
        $shouldCollectionBeFiltered = ! empty(array_filter($componentNamesToFilter));

        return $this->classifiedClassesGroupedByComponentName()
            ->when($shouldCollectionBeFiltered, function ($components) use ($componentNamesToFilter) {
                return $components->filter(function ($_item, $key) use ($componentNamesToFilter) {
                    return in_array($key, $componentNamesToFilter);
                });
            });
    }

    public function statistic(): ProjectStatistic
    {
        return new ProjectStatistic($this);
    }
}
