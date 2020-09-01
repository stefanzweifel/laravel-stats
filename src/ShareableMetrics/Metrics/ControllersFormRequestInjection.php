<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use ReflectionMethod;
use ReflectionParameter;
use Wnx\LaravelStats\Classifiers\RequestClassifier;
use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ControllersFormRequestInjection extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'controllers_form_request_injection';
    }

    public function value()
    {
        return $this->project
                ->classifiedClasses()
                ->filter(function (ClassifiedClass $classifiedClass) {
                    return $classifiedClass->classifier->name() === 'Controllers';
                })
                ->flatMap(function (ClassifiedClass $classifiedClass) {
                    return collect($classifiedClass->reflectionClass->getDefinedMethods());
                })
                ->filter(function (ReflectionMethod $method) {
                    return count($method->getParameters()) > 0;
                })
                ->flatMap(function (ReflectionMethod $method) {
                    return collect($method->getParameters());
                })
                ->filter(function (ReflectionParameter $param) {
                    return $param->hasType();
                })
                ->reject(function (ReflectionParameter $param) {
                    return $param->getType()->isBuiltin();
                })
                ->filter(function (ReflectionParameter $param) {
                    $reflectionClass = new ReflectionClass($param->getType()->getName());

                    return app(RequestClassifier::class)->satisfies($reflectionClass);
                })
                ->count() > 0;
    }
}
