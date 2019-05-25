<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Filters;

use Illuminate\Encryption\Encrypter;
use Wnx\LaravelStats\Classifiers\ModelClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses;
use Wnx\LaravelStats\Tests\TestCase;

class RejectVendorClassesTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_the_given_class_is_a_php_internal()
    {
        $strategy = app(RejectVendorClasses::class);
        $class = new ReflectionClass(new \stdClass);

        $this->assertTrue($strategy->shouldClassBeRejected($class));
    }

    /** @test */
    public function it_returns_true_if_the_class_is_located_in_the_vendor_folder()
    {
        $strategy = app(RejectVendorClasses::class);
        $class = new ReflectionClass(Encrypter::class);

        $this->assertTrue($strategy->shouldClassBeRejected($class));
    }

    /** @test */
    public function it_returns_false_if_the_class_belongs_to_the_app()
    {
        $strategy = app(RejectVendorClasses::class);
        $class = new ReflectionClass(ModelClassifier::class);

        $this->assertFalse($strategy->shouldClassBeRejected($class));
    }
}
