<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class Classifier
{
    const CLASSIFIERS = [
        ControllerClassifier::class,
        ModelClassifier::class,
        CommandClassifier::class,
        RuleClassifier::class,
        PolicyClassifier::class,
        MiddlewareClassifier::class,
        EventClassifier::class,
        MailClassifier::class,
        NotificationClassifier::class,
        JobClassifier::class,
        MigrationClassifier::class,
        RequestClassifier::class,
        ResourceClassifier::class,
        SeederClassifier::class,
        ServiceProviderClassifier::class,
        BrowserKitTestClassifier::class,
        DuskClassifier::class,
        PhpUnitClassifier::class,
    ];

    public function classify(ReflectionClass $class)
    {
        foreach (self::CLASSIFIERS as $classifier) {
            $c = new $classifier();

            if ($c->satisfies($class)) {
                return $c->getName();
            }
        }

        return 'Other';
    }
}
