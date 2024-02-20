<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ValueObjects;

use Illuminate\Support\Collection;

class Component
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
     * @var int
     */
    private $numberOfPublicMethods;

    /**
     * @var int
     */
    private $numberOfNonPublicMethods;

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

    public function __construct(
        public string $name,
        private Collection $classifiedClasses
    ) {
    }

    public function getNumberOfClasses(): int
    {
        if ($this->numberOfClasses === null) {
            $this->numberOfClasses = $this->classifiedClasses->count();
        }

        return $this->numberOfClasses;
    }

    public function getNumberOfMethods(): int
    {
        if ($this->numberOfMethods === null) {
            $this->numberOfMethods = $this->classifiedClasses->sum(static fn (ClassifiedClass $class) => $class->getNumberOfMethods());
        }

        return $this->numberOfMethods;
    }

    public function getNumberOfPublicMethods(): int
    {
        if ($this->numberOfPublicMethods === null) {
            $this->numberOfPublicMethods = $this->classifiedClasses->sum(static fn (ClassifiedClass $class) => $class->getNumberOfPublicMethods());
        }

        return $this->numberOfPublicMethods;
    }

    public function getNumberOfNonPublicMethods(): int
    {
        if ($this->numberOfNonPublicMethods === null) {
            $this->numberOfNonPublicMethods = $this->classifiedClasses->sum(static fn (ClassifiedClass  $class) => $class->getNumberOfNonPublicMethods());
        }

        return $this->numberOfNonPublicMethods;
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
            $this->linesOfCode = $this->classifiedClasses->sum(static fn (ClassifiedClass $class) => $class->getLines());
        }

        return $this->linesOfCode;
    }

    public function getLogicalLinesOfCode(): float
    {
        if ($this->logicalLinesOfCode === null) {
            $this->logicalLinesOfCode = $this->classifiedClasses->sum(static fn (ClassifiedClass $class) => $class->getLogicalLinesOfCode());
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
}
