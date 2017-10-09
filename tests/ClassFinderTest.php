<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\ClassFinder;

class ClassFinderTest extends TestCase
{
    public function getFinder()
    {
        $service = resolve(ClassFinder::class);
        $service->setBasePath(__DIR__.'/../tests/Stubs');

        return $service;
    }

    /** @test */
    public function it_finds_controllers()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController::class));
        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\Controller::class));
    }

    /** @test */
    public function it_finds_commands()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Commands\DemoCommand::class));
    }

    /** @test */
    public function it_finds_events()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent::class));
    }

    /** @test */
    public function it_finds_jobs()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob::class));
    }

    /** @test */
    public function it_finds_mails()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Mail\DemoMail::class));
    }

    /** @test */
    public function it_finds_middlewares()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Middleware\DemoMiddleware::class));
    }

    /** @test */
    public function it_finds_migrations()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Middleware\DemoMiddleware::class));
    }

    /** @test */
    public function it_finds_models()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Models\Project::class));
    }

    /** @test */
    public function it_finds_notifications()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification::class));
    }

    /** @test */
    public function it_finds_policies()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy::class));
    }

    /** @test */
    public function it_finds_request()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest::class));
    }

    /** @test */
    public function it_finds_resources()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Resources\DemoResource::class));
    }

    /** @test */
    public function it_finds_rules()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule::class));
    }

    /** @test */
    public function it_finds_seeders()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Seeder\DemoSeeder::class));
    }

    /** @test */
    public function it_finds_service_providers()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertTrue($classes->contains(\Wnx\LaravelStats\Tests\Stubs\Providers\DemoProvider::class));
    }

    /** @test */
    public function it_does_not_require_files_which_are_set_to_be_ignored()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertFalse($classes->contains('html'));
        $this->assertFalse($classes->contains('blade'));
        $this->assertFalse($classes->contains('twig'));
    }

    /** @test */
    public function it_ignores_native_php_classes()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertFalse($classes->contains('stdClass'));
        $this->assertFalse($classes->contains('Exception'));
    }

    /** @test */
    public function it_ignores_vendored_classes()
    {
        $classes = $this->getFinder()->getDeclaredClasses();

        $this->assertFalse($classes->contains(\Symfony\Component\Finder\Finder::class));
    }
}
