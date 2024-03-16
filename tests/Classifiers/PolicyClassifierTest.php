<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;
use Wnx\LaravelStats\Classifiers\PolicyClassifier;
use Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy;

class PolicyClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_policy_which_has_been_registered_in_the_application(): void
    {
        Gate::policy(Project::class, DemoPolicy::class);

        $this->assertTrue(
            (new PolicyClassifier())->satisfies(
                new ReflectionClass(DemoPolicy::class)
            )
        );
    }

    #[Test]
    public function it_returns_false_if_given_class_is_a_policy_but_has_not_been_registered_to_a_model(): void
    {
        $this->assertFalse(
            (new PolicyClassifier())->satisfies(
                new ReflectionClass(DemoPolicy::class)
            )
        );
    }
}
