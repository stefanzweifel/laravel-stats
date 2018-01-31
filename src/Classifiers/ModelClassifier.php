<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class ModelClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Models';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(Model::class);
    }
}
