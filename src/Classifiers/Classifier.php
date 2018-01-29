<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class Classifier
{
    const DEFAULT_CLASSIFIER = [
        ControllerClassifier::class,
        ModelClassifier::class,
        CommandClassifier::class,
        RuleClassifier::class,
        PolicyClassifier::class,
        MiddlewareClassifier::class,
        EventClassifier::class,
        EventListenerClassifier::class,
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
        $customClassifiers = config('stats.custom_component_classifier', []);
        $mergedClassifiers = array_merge(self::DEFAULT_CLASSIFIER, $customClassifiers);

        foreach ($mergedClassifiers as $classifier) {
            $c = new $classifier();

            if ($c->satisfies($class)) {
                return $c->getName();
            }
        }

        return 'Other';
    }
}
