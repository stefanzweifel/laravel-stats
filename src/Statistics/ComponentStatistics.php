<?php

namespace Wnx\LaravelStats\Statistics;

use Wnx\LaravelStats\Component;
use Illuminate\Support\Collection;
use SebastianBergmann\PHPLOC\Analyser;
use Illuminate\Contracts\Support\Arrayable;

class ComponentStatistics implements Arrayable
{
    /**
     * Component name.
     *
     * @var string
     */
    public $name;

    /**
     * Collection of classes that belong to a given component.
     *
     * @var Illuminate\Support\Collection
     */
    public $classes;

    /**
     * Create new ComponentStatistics instance.
     *
     * @param string     $name
     * @param Collection $classes
     */
    public function __construct(string $name, Collection $classes)
    {
        $this->name = $name;
        $this->classes = $classes;
    }

    /**
     * Return the total number of Classes declared for the component.
     *
     * @return int
     */
    public function getNumberOfClasses() : int
    {
        return $this->classes->count();
    }

    /**
     * Return the total number of Methods declared in all declared classes.
     *
     * @return int
     */
    public function getNumberOfMethods() : int
    {
        return $this->classes
            ->sum(function ($class) {
                return $class->getDefinedMethods()->count();
            });
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
        return $this->classes
            ->map(function ($class) {
                return $class->getFileName();
            })
            ->pipe(function ($classes) {
                return app(Analyser::class)->countFiles($classes->all(), false)['loc'];
            });
    }

    /**
     * Return the total number of lines of code.
     *
     * @return float
     */
    public function getLinesOfCode() : float
    {
        return $this->classes
            ->map(function ($class) {
                return $class->getFileName();
            })
            ->pipe(function ($classes) {
                return app(Analyser::class)->countFiles($classes->all(), false)['lloc'];
            });
    }

    /**
     * Return the average number of lines of code per method.
     *
     * @return float
     */
    public function getLinesOfCodePerMethod() : float
    {
        if ($this->getNumberOfMethods() == 0) {
            return 0;
        }

        return round($this->getLinesOfCode() / $this->getNumberOfMethods(), 2);
    }

    /**
     * Generate Statistics Array for the given Component.
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'component'         => $this->name,
            'number_of_classes' => $this->getNumberOfClasses(),
            'methods'           => $this->getNumberOfMethods(),
            'methods_per_class' => $this->getNumberOfMethodsPerClass(),
            'lines'             => $this->getLines(),
            'loc'               => $this->getLinesOfCode(),
            'loc_per_method'    => $this->getLinesOfCodePerMethod(),
        ];
    }
}
