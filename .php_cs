<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php');

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
    ])
    ->setFinder($finder);
