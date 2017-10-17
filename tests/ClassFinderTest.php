<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\ClassFinder;

class ClassFinderTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        config()->set('stats', [
            'paths' => [
                __DIR__.'/../tests/Stubs',
            ],
            'exclude' => [
                __DIR__.'/../tests/Stubs/ExcludedFile.php',
            ],
        ]);

        $this->classes = app(ClassFinder::class)->getDeclaredClasses();
    }

    /** @test */
    public function it_finds_controllers()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController::class));
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\Controller::class));
    }

    /** @test */
    public function it_finds_commands()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Commands\DemoCommand::class));
    }

    /** @test */
    public function it_finds_events()
    {
        if (! class_exists(\Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent::class)) {
            $this->markTestSkipped('Unsupported on current Laravel version.');
        }

        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent::class));
    }

    /** @test */
    public function it_finds_jobs()
    {
        if (! class_exists(\Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob::class)) {
            $this->markTestSkipped('Unsupported on current Laravel version.');
        }

        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob::class));
    }

    /** @test */
    public function it_finds_mails()
    {
        if (! class_exists(\Wnx\LaravelStats\Tests\Stubs\Mails\DemoMail::class)) {
            $this->markTestSkipped('Unsupported on current Laravel version.');
        }

        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Mails\DemoMail::class));
    }

    /** @test */
    public function it_finds_middlewares()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Middlewares\DemoMiddleware::class));
    }

    /** @test */
    public function it_finds_migrations()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Migrations\CreateUsersTable::class));
    }

    /** @test */
    public function it_finds_models()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Models\Project::class));
    }

    /** @test */
    public function it_finds_notifications()
    {
        if (! class_exists(\Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification::class)) {
            $this->markTestSkipped('Unsupported on current Laravel version.');
        }

        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification::class));
    }

    /** @test */
    public function it_finds_policies()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy::class));
    }

    /** @test */
    public function it_finds_request()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest::class));
    }

    /** @test */
    public function it_finds_resources()
    {
        if (! class_exists(\Wnx\LaravelStats\Tests\Stubs\Resources\DemoResource::class)) {
            $this->markTestSkipped('Unsupported on current Laravel version.');
        }

        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Resources\DemoResource::class));
    }

    /** @test */
    public function it_finds_rules()
    {
        if (! class_exists(\Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule::class)) {
            $this->markTestSkipped('Unsupported on current Laravel version.');
        }

        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule::class));
    }

    /** @test */
    public function it_finds_seeders()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Seeders\DemoSeeder::class));
    }

    /** @test */
    public function it_finds_service_providers()
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\ServiceProviders\DemoProvider::class));
    }

    /** @test */
    public function it_ignores_native_php_classes()
    {
        $this->assertFalse($this->classes->contains('stdClass'));
        $this->assertFalse($this->classes->contains('Exception'));
    }

    /** @test */
    public function it_ignores_exluded_file()
    {
        $this->assertFalse($this->classes->contains('ExcludedFile'));
    }

    /** @test */
    public function it_ignores_vendored_classes()
    {
        $this->assertFalse($this->classes->contains(\Symfony\Component\Finder\Finder::class));
    }
}
