<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Foundation\Http\FormRequest;

class RequestClassifier extends Classifier
{
    public function getName()
    {
        return 'Requests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(FormRequest::class);
    }
}
