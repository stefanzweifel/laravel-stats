<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class ResourceClassifier extends Classifier
{
    public function getName()
    {
        return 'Resources';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\Illuminate\Http\Resources\Json\Resource::class);
    }
}
