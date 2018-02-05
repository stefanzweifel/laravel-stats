<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Mail\Mailable;
use Wnx\LaravelStats\Contracts\Classifier;

class MailClassifier implements Classifier
{
    public function getName()
    {
        return 'Mails';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(Mailable::class);
    }
}
