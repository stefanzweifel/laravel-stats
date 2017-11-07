<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Mail\Mailable;

class MailClassifier extends Classifier
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
