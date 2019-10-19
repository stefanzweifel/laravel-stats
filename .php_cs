<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('vendor')
    ->notPath('test-stubs-nova')
    ->notPath('tests/Stubs')
    ->in(__DIR__)
    ->name('*.php');

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'declare_strict_types' => true
    ])
    ->setFinder($finder);
