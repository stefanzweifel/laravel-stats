<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class RequestClassifier extends Classifier
{
    public function getName()
    {
        return 'Requests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\Illuminate\Foundation\Http\FormRequest::class);
    }
}
