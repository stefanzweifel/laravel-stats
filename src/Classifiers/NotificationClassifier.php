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
        return $class->isSubclassOf(\Illuminate\Notifications\Notification::class);
    }
}
