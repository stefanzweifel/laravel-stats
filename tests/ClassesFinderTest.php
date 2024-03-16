<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\ClassesFinder;

class ClassesFinderTest extends TestCase
{
    protected function setUp() : void
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

    #[Test]
    public function it_finds_controllers(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController::class));
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Controllers\Controller::class));
    }

    #[Test]
    public function it_finds_commands(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Commands\DemoCommand::class));
    }

    #[Test]
    public function it_finds_events(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent::class));
    }

    #[Test]
    public function it_finds_jobs(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob::class));
    }

    #[Test]
    public function it_finds_mails(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Mails\DemoMail::class));
    }

    #[Test]
    public function it_finds_middleware(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Middleware\DemoMiddleware::class));
    }

    #[Test]
    public function it_finds_route_middleware(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Middleware\RouteMiddleware::class));
    }

    #[Test]
    public function it_finds_migrations(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Migrations\CreatePasswordResetsTable::class));
    }

    #[Test]
    public function it_finds_models(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Models\Project::class));
    }

    #[Test]
    public function it_finds_notifications(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification::class));
    }

    #[Test]
    public function it_finds_policies(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy::class));
    }

    #[Test]
    public function it_finds_request(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Requests\UserRequest::class));
    }

    #[Test]
    public function it_finds_resources(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Resources\DemoResource::class));
    }

    #[Test]
    public function it_finds_rules(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule::class));
    }

    #[Test]
    public function it_finds_seeders(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\Seeders\DemoSeeder::class));
    }

    #[Test]
    public function it_finds_service_providers(): void
    {
        $this->assertTrue($this->classes->contains(\Wnx\LaravelStats\Tests\Stubs\ServiceProviders\DemoProvider::class));
    }

    #[Test]
    public function it_includes_native_php_classes(): void
    {
        $this->assertTrue($this->classes->contains('stdClass'));
        $this->assertTrue($this->classes->contains('Exception'));
    }

    #[Test]
    public function it_ignores_exluded_file(): void
    {
        $this->assertFalse($this->classes->contains('ExcludedFile'));
    }

    #[Test]
    public function it_includes_vendored_classes(): void
    {
        $this->assertTrue($this->classes->contains(\Symfony\Component\Finder\Finder::class));
    }
}
