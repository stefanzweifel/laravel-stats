<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\ClassesFinder;

class ClassesFinderTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        $excludedFiles = [
            __DIR__.'/../tests/Stubs/ExcludedFile.php',
        ];

        config()->set('stats', [
            'paths' => [
                __DIR__.'/../tests/Stubs',
                __DIR__.'/../stubs/',
            ],
            'exclude' => $excludedFiles,
            'ignored_namespaces' => [],
        ]);

        $this->classes = app(ClassesFinder::class)->findAndLoadClasses();
    }

    /** @test */
    public function it_finds_controllers(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController::class));
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\Controller::class));
    }

    /** @test */
    public function it_finds_commands(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Commands\DemoCommand::class));
    }

    /** @test */
    public function it_finds_events(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent::class));
    }

    /** @test */
    public function it_finds_jobs(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob::class));
    }

    /** @test */
    public function it_finds_mails(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Mails\DemoMail::class));
    }

    /** @test */
    public function it_finds_middleware(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Middleware\DemoMiddleware::class));
    }

    /** @test */
    public function it_finds_route_middleware(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Middleware\RouteMiddleware::class));
    }

    /** @test */
    public function it_finds_migrations(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Migrations\CreatePasswordResetsTable::class));
    }

    /** @test */
    public function it_finds_models(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Models\Project::class));
    }

    /** @test */
    public function it_finds_notifications(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification::class));
    }

    /** @test */
    public function it_finds_policies(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy::class));
    }

    /** @test */
    public function it_finds_request(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest::class));
    }

    /** @test */
    public function it_finds_resources(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Resources\DemoResource::class));
    }

    /** @test */
    public function it_finds_rules(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule::class));
    }

    /** @test */
    public function it_finds_seeders(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Seeders\DemoSeeder::class));
    }

    /** @test */
    public function it_finds_service_providers(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\ServiceProviders\DemoProvider::class));
    }

    /** @test */
    public function it_includes_native_php_classes(): void
    {
        $this->assertTrue($this->classes->contains('stdClass'));
        $this->assertTrue($this->classes->contains('Exception'));
    }

    /** @test */
    public function it_ignores_exluded_file(): void
    {
        $this->assertFalse($this->classes->contains('ExcludedFile'));
    }

    /** @test */
    public function it_includes_vendored_classes(): void
    {
        $this->assertTrue($this->classes->contains(\Symfony\Component\Finder\Finder::class));
    }
}
