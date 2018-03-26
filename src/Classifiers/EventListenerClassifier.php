<?php

namespace Wnx\LaravelStats\Classifiers;

use Closure;
use ReflectionFunction;
use ReflectionProperty;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class EventListenerClassifier implements Classifier
{
    public function getName()
    {
        return 'Event Listeners';
    }

    public function satisfies(ReflectionClass $class)
    {
        $dispatcher = app('events');

        $property = new ReflectionProperty($dispatcher, 'listeners');
        $property->setAccessible(true);

        return collect($property->getValue($dispatcher))
            ->map(function ($listeners) {
                $subscriber = collect($listeners)->map(function (Closure $closure) {
                    $reflection = new ReflectionFunction($closure);

                    return $reflection->getStaticVariables()['listener'];
                })->toArray();

                return $subscriber;
            })->collapse()
            ->unique()
            ->contains($class->getName());
    }
}
