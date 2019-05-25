<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Contracts\Mail\Mailable;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

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
