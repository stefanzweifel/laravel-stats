<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ControllersCustomInheritance extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'controllers_custom_inheritance';
    }

    public function value()
    {
        $controllers = $this->project
            ->classifiedClasses()
            ->filter(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->classifier->name() === 'Controllers';
            });

        if ($controllers->count() === 0) {
            return null;
        }

        return $controllers
                ->reject(function (ClassifiedClass $classifiedClass) {
                    return $classifiedClass->reflectionClass->getParentClass() === false;
                })

                // Remove Controllers, which extend a Class which is located in the vendor folder
                ->reject(function (ClassifiedClass $classifiedClass) {
                    $parentclass = new ReflectionClass($classifiedClass->reflectionClass->getParentClass()->getName());

                    return $parentclass->isVendorProvided();
                })
                ->reject(function (ClassifiedClass $classifiedClass) {
                    $parentClassName = $classifiedClass->reflectionClass->getParentClass()->getShortName();

                    return $parentClassName === 'Controller';
                })
                ->count() > 0;
    }
}
