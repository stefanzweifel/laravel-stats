<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers\Nova;

use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class Action implements Classifier
{
    public function getName()
    {
        return 'Nova Actions';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(\Laravel\Nova\Actions\Action::class) && $class->isSubclassOf(\Laravel\Nova\Actions\Action::class);
    }
}
