<?php

namespace Wnx\LaravelStats\Classifiers;

use Closure;
use ReflectionFunction;
use ReflectionProperty;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class EventListenerClassifier implements Classifier
{
    public function getName()
    {
        return 'Event Listeners';
    }

    public function satisfies(ReflectionClass $class)
    {
        return collect($this->getEvents())
            ->map(function ($listeners) {
                return collect($listeners)->map(function (Closure $closure) {
                    return $this->getEventListener($closure);
                })->toArray();
            })->collapse()
            ->unique()
            ->contains($class->getName());
    }

    protected function getEvents()
    {
        $dispatcher = app('events');

        $property = new ReflectionProperty($dispatcher, 'listeners');
        $property->setAccessible(true);

        return $property->getValue($dispatcher);
    }

    protected function getEventListener(Closure $closure)
    {
        $reflection = new ReflectionFunction($closure);

        return $reflection->getStaticVariables()['listener'];
    }
}
