<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Http\Resources\Json\Resource;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class ResourceClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Resources';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(Resource::class);
    }
}
