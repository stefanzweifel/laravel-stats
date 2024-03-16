<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\CommandClassifier;
use Wnx\LaravelStats\Tests\Stubs\Commands\DemoCommand;

class CommandClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_artisan_command_is_passed_to_satisfy_method(): void
    {
        $this->assertTrue(
            (new CommandClassifier())->satisfies(
                new ReflectionClass(DemoCommand::class)
            )
        );
    }
}
