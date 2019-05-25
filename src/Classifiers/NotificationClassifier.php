<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Notifications\Notification;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

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
