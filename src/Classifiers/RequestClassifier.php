<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class RequestClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Requests';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Foundation\Http\FormRequest::class);
    }
}
