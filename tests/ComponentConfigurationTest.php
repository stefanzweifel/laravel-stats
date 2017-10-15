<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\ComponentConfiguration;

class ComponentConfigurationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->config = resolve(ComponentConfiguration::class)->get();
    }

    /** @test */
    public function it_has_configuration_for_controllers()
    {
        $this->assertTrue($this->config->contains('name', 'Controllers'));
    }

    /** @test */
    public function it_has_configuration_ofrm_models()
    {
        $this->assertTrue($this->config->contains('name', 'Models'));
    }

    /** @test */
    public function it_has_configuration_for_commands()
    {
        $this->assertTrue($this->config->contains('name', 'Commands'));
    }

    /** @test */
    public function it_has_configuration_for_events()
    {
        $this->assertTrue($this->config->contains('name', 'Events'));
    }

    /** @test */
    public function it_has_configuration_for_mails()
    {
        $this->assertTrue($this->config->contains('name', 'Mails'));
    }

    /** @test */
    public function it_has_configuration_for_notifications()
    {
        $this->assertTrue($this->config->contains('name', 'Notifications'));
    }

    /** @test */
    public function it_has_configuration_for_jobs()
    {
        $this->assertTrue($this->config->contains('name', 'Jobs'));
    }

    /** @test */
    public function it_has_configuration_for_migrations()
    {
        $this->assertTrue($this->config->contains('name', 'Migrations'));
    }

    /** @test */
    public function it_has_configuration_for_seeders()
    {
        $this->assertTrue($this->config->contains('name', 'Seeders'));
    }

    /** @test */
    public function it_has_configuration_for_api_resources()
    {
        $this->assertTrue($this->config->contains('name', 'Resources'));
    }

    /** @test */
    public function it_has_configuration_for_validation_rules()
    {
        $this->assertTrue($this->config->contains('name', 'Rules'));
    }

    /** @test */
    public function it_has_configuration_for_form_requests()
    {
        $this->assertTrue($this->config->contains('name', 'Requests'));
    }

    /** @test */
    public function it_has_configuration_for_service_providers()
    {
        $this->assertTrue($this->config->contains('name', 'Service Providers'));
    }

    /** @test */
    public function it_has_configuration_for_policies()
    {
        $this->assertTrue($this->config->contains('name', 'Policies'));
    }
}
