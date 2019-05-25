<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Foundation\Http\FormRequest;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

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
