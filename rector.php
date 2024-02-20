<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php80: true)
    ->withPreparedSets(deadCode: true, codingStyle: true)
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);
