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
        DuskClassifier::class,
    ];

    public function classify(ReflectionClass $class)
    {
        $name = collect(self::CLASSIFIERS)
            ->map(function ($classifier) {
                return new $classifier;
            })
            ->filter(function ($classifierClass) {
                return $classifierClass instanceof ClassifierInterface;
            })
            ->filter(function (ClassifierInterface $classifier) use ($class) {
                return $classifier->satisfies($class);
            })
            ->map(function (ClassifierInterface $classifier) {
                return $classifier->getName();
            })
            ->first();

        return $name ?: 'Other';
    }
}
