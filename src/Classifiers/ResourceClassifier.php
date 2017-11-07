<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Http\Resources\Json\Resource;

class ResourceClassifier extends Classifier
{
    public function getName()
    {
        return 'Resources';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(Resource::class);
    }
}
