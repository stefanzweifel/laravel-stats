<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\RequestClassifier;
use Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest;

class RequestClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_laravel_form_request(): void
    {
        $this->assertTrue(
            (new RequestClassifier())->satisfies(
                new ReflectionClass(UserRequest::class)
            )
        );
    }
}
