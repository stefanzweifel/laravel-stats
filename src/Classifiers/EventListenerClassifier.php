<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\ServiceProviders\EventServiceProvider;

class EventListenerClassifier extends Classifier
{
    public function getName()
    {
        return 'Event Listeners';
    }

    public function satisfies(ReflectionClass $class)
    {
        return collect(app()->getProvider(EventServiceProvider::class)->listens())
            ->collapse()
            ->unique()
            ->contains($class->getName());
    }
}
