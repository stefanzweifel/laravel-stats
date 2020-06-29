<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Foundation\Http\FormRequest;
use ReflectionMethod;
use ReflectionParameter;
use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ControllerFormRequestInjection extends Metric implements CollectableMetric
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
            ->map(function (ClassifiedClass $classifiedClass) {
                $methods = collect($classifiedClass->reflectionClass->getDefinedMethods());

                return $methods->filter(function (ReflectionMethod $method) {
                    return count($method->getParameters()) > 0;
                })
                    ->filter(function (ReflectionMethod $method) {
                        return collect($method->getParameters())
                            ->filter(function (ReflectionParameter $param) {
                                return $param->hasType();
                            })
                            ->filter(function (ReflectionParameter $param) {
                                $reflectionClass = new ReflectionClass($param->getType()->getName());

                                return $reflectionClass->isSubclassOf(FormRequest::class);
                            });
                    })
                    ->count() > 0;
            })->count() > 0;
    }
}
