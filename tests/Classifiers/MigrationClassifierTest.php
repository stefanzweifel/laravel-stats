<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\MigrationClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Migrations\CreateUsersTable;
use Wnx\LaravelStats\Tests\TestCase;

class MigrationClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_migration()
    {
        require_once __DIR__.'/../Stubs/Migrations/2014_10_12_000000_create_users_table.php';

        $this->assertTrue(
            (new MigrationClassifier())->satisfies(
                new ReflectionClass(CreateUsersTable::class)
            )
        );
    }
}
