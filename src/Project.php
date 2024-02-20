<?php declare(strict_types=1);

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Statistics\ProjectStatistic;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class Project
{
    /**
     * Collection of ClassifiedClasses.
     *
     * @var \Illuminate\Support\Collection <\Wnx\LaravelStats\ValueObjects\ClassifiedClass>
     */
    private $classifiedClasses;

    public function __construct(
        private Collection $classes
    ) {
        // Loop through ReflectionClasses and classify them.
        $this->classifiedClasses = $this->classes->map(static fn (ReflectionClass $reflectionClass) => new ClassifiedClass(
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
            ->groupBy(static fn (ClassifiedClass $classifiedClass) => $classifiedClass->classifier->name())
            ->sortBy(static fn ($_, string $componentName) => $componentName);
    }

    public function classifiedClassesGroupedAndFilteredByComponentNames(array $componentNamesToFilter = []): Collection
    {
        $shouldCollectionBeFiltered = ! empty(array_filter($componentNamesToFilter));

        return $this->classifiedClassesGroupedByComponentName()
            ->when(
                $shouldCollectionBeFiltered,
                static fn (Collection $components) => $components->filter(static fn ($_item, string $key) => in_array($key, $componentNamesToFilter))
            );
    }

    public function statistic(): ProjectStatistic
    {
        return new ProjectStatistic($this);
    }
}
