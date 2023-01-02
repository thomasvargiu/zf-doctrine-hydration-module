<?php
$finder = \PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('config')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/test')
    ->name('*.php')
;

$config = new \PhpCsFixer\Config();
$config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
]);
$config->setFinder($finder);

return $config;
