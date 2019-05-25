<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Http\Resources\Json\Resource;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class ResourceClassifier implements Classifier
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
