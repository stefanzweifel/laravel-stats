<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class ModelClassifier extends Classifier
{
    public function getName()
    {
        return 'Models';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\Illuminate\Database\Eloquent\Model::class);
    }
}
