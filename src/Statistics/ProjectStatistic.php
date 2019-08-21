<?php

namespace Wnx\LaravelStats\Statistics;

use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ProjectStatistic
{
    /**
     * @var Wnx\LaravelStats\Project
     */
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getNumberOfClasses(): int
    {
        return $this->project->classifiedClasses()->count();
    }

    public function getNumberOfMethods(): int
    {
        return $this->project->classifiedClasses()->sum(function (ClassifiedClass $class) {
            return $class->getNumberOfMethods();
        });
    }

    public function getNumberOfMethodsPerClass(): float
    {
        return round($this->getNumberOfMethods() / $this->getNumberOfClasses(), 2);
    }

    public function getLinesOfCode(): int
    {
        return $this->project->classifiedClasses()->sum(function (ClassifiedClass $class) {
            return $class->getLines();
        });
    }

    public function getLogicalLinesOfCode(): int
    {
        return $this->project->classifiedClasses()->sum(function (ClassifiedClass $class) {
            return $class->getLogicalLinesOfCode();
        });
    }

    public function getLogicalLinesOfCodePerMethod(): float
    {
        if ($this->getNumberOfMethods() === 0) {
            return 0;
        }

        return round($this->getLogicalLinesOfCode() / $this->getNumberOfMethods(), 2);
    }


}
