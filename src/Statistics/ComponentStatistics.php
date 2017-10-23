<?php

namespace Wnx\LaravelStats\Statistics;

use Wnx\LaravelStats\Component;
use SebastianBergmann\PHPLOC\Analyser;

class ComponentStatistics
{
    /**
     * @var \Wnx\LaravelStats\Statistics\ProjectStatistics
     */
    public $project;

    /**
     * @var \Wnx\LaravelStats\Component
     */
    public $component;

    public function __construct(ProjectStatistics $project, Component $component)
    {
        $this->project = $project;
        $this->component = $component;
    }

    /**
     * Generate Statistics Array for the given Component.
     *
     * @return array
     */
    public function getAsArray() : array
    {
        if (str_contains($this->component->getName(), 'Tests')) {
            $this->project->incrementTestLinesOfCode(
                $loc = $this->getLinesOfCode()
            );
        } else {
            $this->project->incrementCodeLinesOfCode(
                $loc = $this->getLinesOfCode()
            );
        }

        return [
            'component'         => $this->component->getName(),
            'number_of_classes' => $this->getNumberOfClasses(),
            'methods'           => $this->getNumberOfMethods(),
            'methods_per_class' => $this->getNumberOfMethodsPerClass(),
            'lines'             => $this->getLines(),
            'loc'               => $loc,
            'loc_per_method'    => $this->getLinesOfCodePerMethod(),
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
        return $this->component->getClasses()
            ->map(function ($class) {
                return $class->getDefinedMethods()->count();
            })
            ->sum();
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
            $classPaths[] = $reflection->getFileName();
        }

        $service = resolve(Analyser::class);

        return $service->countFiles($classPaths, false)['loc'];
    }

    /**
     * Return the total number of lines of code.
     *
     * @return float
     */
    public function getLinesOfCode() : float
    {
        $classPaths = [];

        foreach ($this->component->getClasses() as $reflection) {
            $classPaths[] = $reflection->getFileName();
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
