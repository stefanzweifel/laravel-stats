<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php82: true)
    ->withPreparedSets(deadCode: true, codingStyle: true)
    ->withSets([
        PHPUnitSetList::PHPUNIT_100,
    ])
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ])
    ->withSkip([
        FirstClassCallableRector::class => [
            __DIR__ . '/tests/Stubs/EventListeners/UserEventSubscriber.php',
        ],
    ]);
