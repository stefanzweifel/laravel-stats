<?php

namespace Wnx\LaravelStats\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use SebastianBergmann\PHPLOC\Analyser;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class ComponentClass implements Arrayable
{
    /**
     * @var \Wnx\LaravelStats\ReflectionClass
     */
    private $reflectionClassInstance;

    /**
     * ahdjkashd
     * @var \Wnx\LaravelStats\Contracts\Classifier
     */
    private $classifier;

    public function __construct(ReflectionClass $reflectionClassInstance, Classifier $classifier)
    {
        $this->reflectionClassInstance = $reflectionClassInstance;
        $this->classifier = $classifier;
    }

    public function getReflectionClass(): ReflectionClass
    {
        return $this->reflectionClassInstance;
    }

    public function getClassifier(): Classifier
    {
        return $this->classifier;
    }

    /**
     * Return the total number of Methods declared in all declared classes.
     *
     * @return int
     */
    public function getNumberOfMethods(): int
    {
        return $this->reflectionClassInstance->getDefinedMethods()->count();
    }

    /**
     * Return the total number of lines.
     *
     * @return int
     */
    public function getLines(): int
    {
        return app(Analyser::class)
            ->countFiles([$this->reflectionClassInstance->getFileName()], false)['loc'];
    }

    /**
     * Return the total number of lines of code.
     *
     * @return float
     */
    public function getLogicalLinesOfCode(): float
    {
        return app(Analyser::class)
            ->countFiles([$this->reflectionClassInstance->getFileName()], false)['lloc'];
    }

    /**
     * Return the average number of lines of code per method.
     *
     * @return float
     */
    public function getLogicalLinesOfCodePerMethod(): float
    {
        if ($this->getNumberOfMethods() === 0) {
            return 0;
        }

        return round($this->getLogicalLinesOfCode() / $this->getNumberOfMethods(), 2);
    }

    public function toArray(): array
    {
        return [
            'component_name' => $this->classifier->name(),
            'methods' => $this->getNumberOfMethods(),
            'loc' => $this->getLines(),
            'lloc' => $this->getLogicalLinesOfCode(),
            'lloc_per_method' => $this->getLogicalLinesOfCodePerMethod()
        ];
    }

}
