<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics;

use Wnx\LaravelStats\ShareableMetrics\AllMetricPayloadKeys;
use Wnx\LaravelStats\Tests\TestCase;

class AllMetricPayloadKeysTest extends TestCase
{
    /** @test */
    public function it_returns_an_array_of_all_possible_keys_the_payload_can_contain()
    {
        $result = app(AllMetricPayloadKeys::class)->get();

        $this->assertIsArray($result);

        $this->assertContains('packages', $result);
        $this->assertContains('routes', $result);
        $this->assertContains('models_mass_assignment', $result);
        $this->assertContains('controllers_lloc_per_method', $result);
        $this->assertContains('nova_lenses_methods', $result);
    }
}
