<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Database\Eloquent\Model;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class ModelClassifier implements Classifier
{
    public function getName()
    {
        return 'Models';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(Model::class);
    }
}
