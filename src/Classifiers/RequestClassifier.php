<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Foundation\Http\FormRequest;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class RequestClassifier extends BaseClassifier implements Classifier
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
