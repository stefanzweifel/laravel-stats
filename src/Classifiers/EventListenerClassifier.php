<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Closure;
use ReflectionFunction;
use ReflectionProperty;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class EventListenerClassifier implements Classifier
{
    public function name(): string
    {
        return 'Event Listeners';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return collect($this->getEvents())
            ->map(function ($listeners) {
                $subscriber = collect($listeners)->map(function (Closure $closure) {
                    return $this->getEventListener($closure);
                })->toArray();

                return $subscriber;
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

    public function countsTowardsApplicationCode(): bool
    {
        return true;
    }

    public function countsTowardsTests(): bool
    {
        return false;
    }
}
