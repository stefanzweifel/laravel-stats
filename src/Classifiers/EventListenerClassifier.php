<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class EventListenerClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Event Listeners';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return collect(app()->getProvider(EventServiceProvider::class)->listens())
            ->collapse()
            ->unique()
            ->contains($class->getName());
    }
}
