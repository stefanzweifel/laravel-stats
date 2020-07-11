<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Closure;
use Illuminate\Support\Str;
use ReflectionFunction;
use ReflectionProperty;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class ObserverClassifier implements Classifier
{
    public function name(): string
    {
        return 'Observers';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return collect($this->getEvents())
            ->filter(function ($listeners, $event) {
                return Str::of($event)->startsWith('eloquent.');
            })
            ->map(function ($listeners) {
                return collect($listeners)->map(function (Closure $closure) {
                    return $this->getEventListener($closure);
                })->toArray();
            })
            ->collapse()
            ->unique()
            ->filter(function ($eventListenerSignature) use ($class) {
                return Str::of($eventListenerSignature)->contains($class->getName());
            })
            ->count() > 0;
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
