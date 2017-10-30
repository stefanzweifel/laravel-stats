<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Wnx\LaravelStats\ReflectionClass;

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
