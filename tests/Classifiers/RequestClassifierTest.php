<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\RequestClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest;
use Wnx\LaravelStats\Tests\TestCase;

class RequestClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_laravel_form_request()
    {
        $this->assertTrue(
            (new RequestClassifier())->satisfies(
                new ReflectionClass(UserRequest::class)
            )
        );
    }
}
