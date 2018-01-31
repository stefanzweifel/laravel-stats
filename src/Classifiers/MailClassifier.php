<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Mail\Mailable;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class MailClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Mails';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(Mailable::class);
    }
}
