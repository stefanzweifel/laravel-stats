<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\ComponentConfiguration;
use Wnx\LaravelStats\Tests\TestCase;

class ComponentConfigurationTest extends TestCase
{
    /** @test */
    public function it_has_configuration_for_controllers()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Controllers'));
    }

    /** @test */
    public function it_has_configuration_ofrm_models()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Models'));
    }

    /** @test */
    public function it_has_configuration_for_commands()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Commands'));
    }

    /** @test */
    public function it_has_configuration_for_events()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Events'));
    }

    /** @test */
    public function it_has_configuration_for_mails()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Mails'));
    }

    /** @test */
    public function it_has_configuration_for_notifications()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Notifications'));
    }

    /** @test */
    public function it_has_configuration_for_jobs()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Jobs'));
    }

    /** @test */
    public function it_has_configuration_for_migrations()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Migrations'));
    }

    /** @test */
    public function it_has_configuration_for_seeders()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Seeders'));
    }

    /** @test */
    public function it_has_configuration_for_api_resources()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Resources'));
    }

    /** @test */
    public function it_has_configuration_for_validation_rules()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Rules'));
    }

    /** @test */
    public function it_has_configuration_for_form_requests()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Requests'));
    }

    /** @test */
    public function it_has_configuration_for_service_providers()
    {
        $config = resolve(ComponentConfiguration::class)->get();

        $this->assertTrue($config->contains('name', 'Service Providers'));
    }

}
