<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Closure;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionFunction;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class ObserverClassifier implements Classifier
{
    public function name(): string
    {
        return 'Observers';
    }

    /**
     * @throws \ReflectionException
     */
    public function satisfies(ReflectionClass $class): bool
    {
        return collect($this->getEvents())
            ->filter(static fn ($_listeners, $event) => Str::startsWith($event, 'eloquent.'))
            ->map(fn ($listeners) => collect($listeners)->map(fn ($closure) => $this->getEventListener($closure))->toArray())
            ->collapse()
            ->unique()
            ->filter(static fn ($eventListener) => is_string($eventListener))
            ->filter(static fn (string $eventListenerSignature) => Str::contains($eventListenerSignature, $class->getName()))
            ->count() > 0;
    }

    /**
     * @throws \ReflectionException
     */
    protected function getEvents()
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = app('events');

        return $dispatcher->getRawListeners();
    }

    /**
     * @param Closure|string $closure
     * @retrun null|string|object
     * @throws \ReflectionException
     */
    protected function getEventListener($closure)
    {
        if (is_string($closure)) {
            return $closure;
        }

        $reflection = new ReflectionFunction($closure);

        return Arr::get($reflection->getStaticVariables(), 'listener');
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
