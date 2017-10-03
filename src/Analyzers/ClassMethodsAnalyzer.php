<?php

namespace Wnx\LaravelStats\Analyzers;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionMethod;

class ClassMethodsAnalyzer
{
    /**
     * Return the total numbers of methods declared on the given class.
     *
     * @param ReflectionClass $class
     *
     * @return int
     */
    public function getNumberOfMethods(ReflectionClass $class) : int
    {
        return $this->getMethodsWithoutTraitMethods($class)->count();
    }

    /**
     * Return a Collection of method names grouped by visibility.
     *
     * @param ReflectionClass $class
     *
     * @return Collection
     */
    public function getCollectionOfMethodNames(ReflectionClass $class) : Collection
    {
        return $this->getMethodsWithoutTraitMethods($class);
    }

    /**
     * @url https://stackoverflow.com/a/27817897/3863449
     */
    protected function getMethods(ReflectionClass $class, $inherit = false, $static = null, $scope = ['public', 'protected', 'private']) : Collection
    {
        $return = [
            'public'    => [],
            'protected' => [],
            'private'   => [],
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

        $return = collect($return)->collapse();

        return $return;
    }

    /**
     * Return a Collection of Method Names which are only declared on the class itself
     * Methods declared on a used trait are beeing ignored
     *
     * @param  ReflectionClass $class
     *
     * @return Collection
     */
    public function getMethodsWithoutTraitMethods(ReflectionClass $class) : Collection
    {
        return $this->getMethods($class)->diff(
            collect($this->getTraitMethods($class))
        );
    }

    /**
     * Get an Array of Trait Methods
     * @return array
     */
    protected function getTraitMethods($class) : array
    {
        $methods = [];
        $traits = $class->getTraits();

        foreach($traits as $trait) {
            foreach($trait->getMethods() as $method) {
                $methods[] = $method->getName();
            }
        }

        return $methods;
    }

}
