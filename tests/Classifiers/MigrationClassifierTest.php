<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\Stubs\Migrations\CreatePasswordResetsTable;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\MigrationClassifier;

class MigrationClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_migration(): void
    {
        require_once __DIR__.'/../Stubs/Migrations/2014_10_12_100000_create_password_resets_table.php';

        $this->assertTrue(
            (new MigrationClassifier())->satisfies(
                new ReflectionClass(CreatePasswordResetsTable::class)
            )
        );
    }

    /** @test */
    public function it_detects_anonymous_migrations(): void
    {
        $createUsersTableMigration = require __DIR__.'/../Stubs/Migrations/2014_10_12_000000_create_users_table.php';

        $reflectionClass = new ReflectionClass($createUsersTableMigration);

        $this->assertTrue(
            (new MigrationClassifier())->satisfies(
                $reflectionClass
            )
        );
    }
}
