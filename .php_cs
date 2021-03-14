<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src/', __DIR__ . '/tests/']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2'        => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder);
