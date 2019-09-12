<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class ResourceClassifier implements Classifier
{
    public function name(): string
    {
        return 'Resources';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        if ($class->isSubclassOf(Resource::class)) {
            return true;
        }

        if ($class->isSubclassOf(JsonResource::class)) {
            return true;
        }

        if ($class->isSubclassOf(ResourceCollection::class)) {
            return true;
        }

        return false;
    }

    public function countsTowardsApplicationCode(): bool
    {
        return true;
    }

    public function countsTowardsTests(): bool
    {
        return false;
    }
}
