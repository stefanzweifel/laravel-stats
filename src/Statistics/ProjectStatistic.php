<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Statistics;

use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ProjectStatistic
{
    /**
     * @var int
     */
    private $numberOfClasses;

    /**
     * @var int
     */
    private $numberOfMethods;

    /**
     * @var float
     */
    private $numberOfMethodsPerClass;

    /**
     * @var int
     */
    private $linesOfCode;

    /**
     * @var int
     */
    private $logicalLinesOfCode;

    /**
     * @var float
     */
    private $logicalLinesOfCodePerMethod;

    public function __construct(private Project $project)
    {
    }

    public function getNumberOfClasses(): int
    {
        if ($this->numberOfClasses === null) {
            $this->numberOfClasses = $this->project->classifiedClasses()->count();
        }

        return $this->numberOfClasses;
    }

    public function getNumberOfMethods(): int
    {
        if ($this->numberOfMethods === null) {
            $this->numberOfMethods = $this->project->classifiedClasses()->sum(static fn (ClassifiedClass $class) => $class->getNumberOfMethods());
        }

        return $this->numberOfMethods;
    }

    public function getNumberOfMethodsPerClass(): float
    {
        if ($this->numberOfMethodsPerClass === null) {
            $this->numberOfMethodsPerClass = round($this->getNumberOfMethods() / $this->getNumberOfClasses(), 2);
        }

        return $this->numberOfMethodsPerClass;
    }

    public function getLinesOfCode(): int
    {
        if ($this->linesOfCode === null) {
            $this->linesOfCode = $this->project->classifiedClasses()->sum(static fn (ClassifiedClass $class) => $class->getLines());
        }

        return $this->linesOfCode;
    }

    public function getLogicalLinesOfCode(): float
    {
        if ($this->logicalLinesOfCode === null) {
            $this->logicalLinesOfCode = $this->project->classifiedClasses()->sum(static fn (ClassifiedClass $class) => $class->getLogicalLinesOfCode());
        }

        return $this->logicalLinesOfCode;
    }

    public function getLogicalLinesOfCodePerMethod(): float
    {
        if ($this->logicalLinesOfCodePerMethod === null) {
            if ($this->getNumberOfMethods() === 0) {
                $this->logicalLinesOfCodePerMethod = 0;
            } else {
                $this->logicalLinesOfCodePerMethod = round($this->getLogicalLinesOfCode() / $this->getNumberOfMethods(), 2);
            }
        }

        return $this->logicalLinesOfCodePerMethod;
    }

    public function getLogicalLinesOfCodeForApplicationCode(): float
    {
        return $this
            ->project
            ->classifiedClasses()
            ->filter(static fn (ClassifiedClass $classifiedClass) => $classifiedClass->classifier->countsTowardsApplicationCode())
            ->sum(static fn (ClassifiedClass $class) => $class->getLogicalLinesOfCode());
    }

    public function getLogicalLinesOfCodeForTestCode(): float
    {
        return $this
            ->project
            ->classifiedClasses()
            ->filter(static fn (ClassifiedClass $classifiedClass) => $classifiedClass->classifier->countsTowardsTests())
            ->sum(static fn (ClassifiedClass $class) => $class->getLogicalLinesOfCode());
    }

    public function getApplicationCodeToTestCodeRatio(): float
    {
        return round(
            $this->getLogicalLinesOfCodeForTestCode() / $this->getLogicalLinesOfCodeForApplicationCode(),
            1
        );
    }
}
