<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\Classifiers\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class ClassifierTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->classifier = new Classifier;
    }

    /** @test */
    public function it_returns_null_for_unidentified_class()
    {
        $this->assertNull(
            $this->classifier->classify(new ReflectionClass(new class {}))
        );
    }

    /** @test */
    public function it_detects_commands()
    {
        $this->assertSame(
            'Commands', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Commands\DemoCommand::class))
        );
    }

    /** @test */
    public function it_detects_controllers()
    {
        $this->assertSame(
            'Controllers', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController::class))
        );
    }

    /** @test */
    public function it_detects_controllers_which_do_not_extend_the_illuminate_base_controller()
    {
        Route::get('pages', '\Wnx\LaravelStats\Tests\Stubs\Controllers\PagesController@index');

        $this->assertSame(
            'Controllers', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Controllers\PagesController::class))
        );
    }

    /** @test */
    public function it_detects_events()
    {
        $this->assertSame(
            'Events', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent::class))
        );
    }

    /** @test */
    public function it_detects_jobs()
    {
        $this->assertSame(
            'Jobs', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob::class))
        );
    }

    /** @test */
    public function it_detects_mails()
    {
        $this->assertSame(
            'Mails', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Mails\DemoMail::class))
        );
    }

    /** @test */
    public function it_detects_middlewares()
    {
        $this->assertSame(
            'Middlewares', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Middlewares\DemoMiddleware::class))
        );
    }

    /** @test */
    public function it_detects_migrations()
    {
        $this->assertSame(
            'Migrations', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Migrations\CreateUsersTable::class))
        );

    }

    /** @test */
    public function it_detects_models()
    {
        $this->assertSame(
            'Models', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Models\Project::class))
        );
    }

    /** @test */
    public function it_detects_notifications()
    {
        $this->assertSame(
            'Notifications', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification::class))
        );
    }

    /** @test */
    public function it_detects_policies()
    {
        Gate::policy(Project::class, \Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy::class);

        $this->assertSame(
            'Policies', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy::class))
        );
    }

    /** @test */
    public function it_detects_requests()
    {
        $this->assertSame(
            'Requests', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest::class))
        );
    }

    /** @test */
    public function it_detects_resources()
    {
        $this->assertSame(
            'Resources', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Resources\DemoResource::class))
        );
    }

    /** @test */
    public function it_detects_rules()
    {
        $this->assertSame(
            'Rules', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule::class))
        );
    }

    /** @test */
    public function it_detects_seeders()
    {
        $this->assertSame(
            'Seeders', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\Seeders\DemoSeeder::class))
        );
    }

    /** @test */
    public function it_detects_service_providers()
    {
        $this->assertSame(
            'Service Providers', $this->classifier->classify(new ReflectionClass(\Wnx\LaravelStats\Tests\Stubs\ServiceProviders\DemoProvider::class))
        );
    }
}
