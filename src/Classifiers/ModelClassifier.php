<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class ModelClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Models';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Database\Eloquent\Model::class);
    }
}
