<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers\Nova;

use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class Filter implements Classifier
{
    public function getName()
    {
        return 'Nova Filters';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(\Laravel\Nova\Filters\Filter::class) && $class->isSubclassOf(\Laravel\Nova\Filters\Filter::class);
    }
}
