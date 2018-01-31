<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Notifications\Notification;
use Wnx\LaravelStats\Contracts\Classifier;

class NotificationClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Notifications';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(Notification::class);
    }
}
