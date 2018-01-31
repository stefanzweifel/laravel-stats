<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Notifications\Notification;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class NotificationClassifier extends BaseClassifier implements Classifier
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
