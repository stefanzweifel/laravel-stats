<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class MailClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Mails';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Mail\Mailable::class);
    }
}
