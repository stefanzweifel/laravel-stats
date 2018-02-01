<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Foundation\Http\FormRequest;

class RequestClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Requests';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(FormRequest::class);
    }
}
