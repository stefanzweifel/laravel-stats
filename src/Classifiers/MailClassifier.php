<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class MailClassifier extends Classifier
{
    public function getName()
    {
        return 'Mails';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (! class_exists(\Illuminate\Mail\Mailable::class)) {
            return false;
        }

        return $class->isSubclassOf(\Illuminate\Mail\Mailable::class);
    }
}
