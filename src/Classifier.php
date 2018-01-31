<?php

namespace Wnx\LaravelStats;

use Wnx\LaravelStats\Classifiers\BrowserKitTestClassifier;
use Wnx\LaravelStats\Classifiers\CommandClassifier;
use Wnx\LaravelStats\Classifiers\ControllerClassifier;
use Wnx\LaravelStats\Classifiers\DuskClassifier;
use Wnx\LaravelStats\Classifiers\EventClassifier;
use Wnx\LaravelStats\Classifiers\EventListenerClassifier;
use Wnx\LaravelStats\Classifiers\JobClassifier;
use Wnx\LaravelStats\Classifiers\MailClassifier;
use Wnx\LaravelStats\Classifiers\MiddlewareClassifier;
use Wnx\LaravelStats\Classifiers\MigrationClassifier;
use Wnx\LaravelStats\Classifiers\ModelClassifier;
use Wnx\LaravelStats\Classifiers\NotificationClassifier;
use Wnx\LaravelStats\Classifiers\PhpUnitClassifier;
use Wnx\LaravelStats\Classifiers\PolicyClassifier;
use Wnx\LaravelStats\Classifiers\RequestClassifier;
use Wnx\LaravelStats\Classifiers\ResourceClassifier;
use Wnx\LaravelStats\Classifiers\RuleClassifier;
use Wnx\LaravelStats\Classifiers\SeederClassifier;
use Wnx\LaravelStats\Classifiers\ServiceProviderClassifier;
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
