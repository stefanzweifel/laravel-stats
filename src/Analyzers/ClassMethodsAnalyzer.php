<?php

namespace Wnx\LaravelStats\Analyzers;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionMethod;

class ClassMethodsAnalyzer
{
    /**
     * Return the total numbers of methods declared on the given class
     * @param  ReflectionClass $class
     * @return int
     */
    public function getNumberOfMethods(ReflectionClass $class) : int
    {
        return $this->getMethods($class)->collapse()->count();
    }

    /**
     * Return a Collection of method names grouped by visibility
     * @param  ReflectionClass $class
     * @return Collection
     */
    public function getCollectionOfMethodNames(ReflectionClass $class) : Collection
    {
        return $this->getMethods($class);
    }

    /**
     * @url https://stackoverflow.com/a/27817897/3863449
     */
    protected function getMethods(ReflectionClass $class, $inherit = false, $static = null, $scope = ['public', 'protected', 'private']) : Collection
    {
        $return = [
            'public' => [],
            'protected' => [],
            'private' => []
        ];

        foreach ($scope as $key) {
            $pass = false;
            switch ($key) {
                case 'public': $pass = ReflectionMethod::IS_PUBLIC;
                    break;
                case 'protected': $pass = ReflectionMethod::IS_PROTECTED;
                    break;
                case 'private': $pass = ReflectionMethod::IS_PRIVATE;
                    break;
            }
            if ($pass) {
                $methods = $class->getMethods($pass);
                foreach ($methods as $method) {
                    $isStatic = $method->isStatic();
                    if (!is_null($static) && $static && !$isStatic) {
                        continue;
                    } elseif (!is_null($static) && !$static && $isStatic) {
                        continue;
                    }
                    if (!$inherit && $method->class === $class->getName()) {
                        $return[$key][] = $method->name;
                    } elseif ($inherit) {
                        $return[$key][] = $method->name;
                    }
                }
            }
        }
        return collect($return);
    }
}
