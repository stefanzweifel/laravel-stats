<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class NotificationClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Notifications';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Notifications\Notification::class);
    }
}
