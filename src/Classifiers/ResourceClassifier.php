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
        if (! class_exists(\Illuminate\Http\Resources\Json\Resource::class)) {
            return false;
        }
        
        return $class->isSubclassOf(\Illuminate\Http\Resources\Json\Resource::class);
    }
}
