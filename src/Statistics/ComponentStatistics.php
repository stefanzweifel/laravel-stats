<?php

namespace Wnx\LaravelStats\Statistics;

use SebastianBergmann\PHPLOC\Analyser;
use Wnx\LaravelStats\Component;

class ComponentStatistics
{
    /**
     * @var Wnx\LaravelStats\Component
     */
    public $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    /**
     * Generate Statistics Array for the given Component.
     *
     * @return array
     */
    public function getAsArray() : array
    {
        return [
            'component'         => $this->component->getName(),
            'number_of_classes' => number_format($this->getNumberOfClasses(). 0),
            'methods'           => number_format($this->getNumberOfMethods(), 0),
            'methods_per_class' => number_format($this->getNumberOfMethodsPerClass(), 2),
            'lines'             => number_format($this->getLines(), 0),
            'loc'               => number_format($this->getLinesOfCode(), 0),
            'loc_per_method'    => number_format($this->getLinesOfCodePerMethod(), 2),
        ];
    }

    /**
     * Return the total number of Classes declared for the component.
     *
     * @return int
     */
    public function getNumberOfClasses() : int
    {
        return count($this->component->getClasses());
    }

    /**
     * Return the total number of Methods declared in all declared classes.
     *
     * @return int
     */
    public function getNumberOfMethods() : int
    {
        $methods = 0;

        foreach ($this->component->getClasses() as $reflection) {
            $classStats = new ClassStatistics($reflection);
            $methods += $classStats->getNumberOfMethods();
        }

        return $methods;
    }

    /**
     * Return the average number of methods per class.
     *
     * @return float
     */
    public function getNumberOfMethodsPerClass() : float
    {
        if ($this->getNumberOfClasses() == 0) {
            return 0;
        }

        return round($this->getNumberOfMethods() / $this->getNumberOfClasses(), 2);
    }

    /**
     * Return the total number of lines.
     *
     * @return int
     */
    public function getLines() : int
    {
        $classPaths = [];

        foreach ($this->component->getClasses() as $reflection) {
            $classPaths[] = $reflection->getNativeReflectionClass()->getFileName();
        }

        $service = resolve(Analyser::class);

        return $service->countFiles($classPaths, false)['loc'];
    }

    /**
     * Return the total number of lines of code.
     *
     * @return int
     */
    public function getLinesOfCode() : float
    {
        $classPaths = [];

        foreach ($this->component->getClasses() as $reflection) {
            $classPaths[] = $reflection->getNativeReflectionClass()->getFileName();
        }

        $service = resolve(Analyser::class);

        return $service->countFiles($classPaths, false)['lloc'];
    }

    /**
     * Return the average number of lines of code per method.
     *
     * @return float
     */
    public function getLinesOfCodePerMethod() : float
    {
        $numberOfMethods = $this->getNumberOfMethods();

        if ($numberOfMethods == 0) {
            return 0;
        }

        return round($this->getLinesOfCode() / $this->getNumberOfMethods(), 2);
    }
}
