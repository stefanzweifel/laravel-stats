<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ValueObjects;

use Wnx\LaravelStats\ReflectionClass;
use SebastianBergmann\PHPLOC\Analyser;
use Wnx\LaravelStats\Contracts\Classifier;

class ClassifiedClass
{
    /**
     * @var \Wnx\LaravelStats\ReflectionClass
     */
    public $reflectionClass;

    /**
     * Classifier Instance related to the Reflection Class.
     *
     * @var \Wnx\LaravelStats\Contracts\Classifier
     */
    public $classifier;

    /**
     * @var int
     */
    private $numberOfMethods;

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

    public function __construct(ReflectionClass $reflectionClass, Classifier $classifier)
    {
        $this->reflectionClass = $reflectionClass;
        $this->classifier = $classifier;
    }

    /**
     * Return the total number of Methods declared in all declared classes.
     *
     * @return int
     */
    public function getNumberOfMethods(): int
    {
        if ($this->numberOfMethods === null) {
            $this->numberOfMethods = $this->reflectionClass->getDefinedMethods()->count();
        }

        return $this->numberOfMethods;
    }

    /**
     * Return the total number of lines.
     *
     * @return int
     */
    public function getLines(): int
    {
        if ($this->linesOfCode === null) {
            $this->linesOfCode = app(Analyser::class)
                ->countFiles([$this->reflectionClass->getFileName()], false)['loc'];
        }

        return $this->linesOfCode;
    }

    /**
     * Return the total number of lines of code.
     *
     * @return float
     */
    public function getLogicalLinesOfCode(): float
    {
        if ($this->logicalLinesOfCode === null) {
            $this->logicalLinesOfCode = app(Analyser::class)
                ->countFiles([$this->reflectionClass->getFileName()], false)['lloc'];
        }

        return $this->logicalLinesOfCode;
    }

    /**
     * Return the average number of lines of code per method.
     *
     * @return float
     */
    public function getLogicalLinesOfCodePerMethod(): float
    {
        if ($this->logicalLinesOfCodePerMethod === null) {
            if ($this->getNumberOfMethods() === 0) {
                $this->logicalLinesOfCodePerMethod = $this->logicalLinesOfCodePerMethod = 0;
            } else {
                $this->logicalLinesOfCodePerMethod = round($this->getLogicalLinesOfCode() / $this->getNumberOfMethods(), 2);
            }
        }

        return $this->logicalLinesOfCodePerMethod;
    }
}
