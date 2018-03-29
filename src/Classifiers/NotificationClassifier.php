<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Notifications\Notification;
use Wnx\LaravelStats\Contracts\Classifier;

class NotificationClassifier implements Classifier
{
    public function getName()
    {
        return 'Notifications';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (! class_exists(Notification::class)) {
            return false;
        }

        return $class->isSubclassOf(Notification::class);
    }
}
