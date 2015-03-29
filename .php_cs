<?php

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude(array(
            'config',
            'test',
            'vendor',
    ))
    ->in(__DIR__.'/src');

return Symfony\CS\Config\Config::create()
    ->finder($finder)
    ->fixers(array(
        FixerInterface::PSR2_LEVEL,
        '-concat_without_spaces'
    ));
