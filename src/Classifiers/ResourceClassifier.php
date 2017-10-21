<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class ResourceClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Resources';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Http\Resources\Json\Resource::class);
    }
}
