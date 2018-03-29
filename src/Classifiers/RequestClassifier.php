<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Foundation\Http\FormRequest;

class RequestClassifier implements Classifier
{
    public function getName()
    {
        return 'Requests';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (! class_exists(FormRequest::class)) {
            return false;
        }

        return $class->isSubclassOf(FormRequest::class);
    }
}
