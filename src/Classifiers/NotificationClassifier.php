<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class NotificationClassifier extends Classifier
{
    public function getName()
    {
        return 'Notifications';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (! class_exists(\Illuminate\Notifications\Notification::class)) {
            return;
        }

        return $class->isSubclassOf(\Illuminate\Notifications\Notification::class);
    }
}
