<?php

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\PHPUnit\Set\PHPUnitSetList;

return RectorConfig::configure()
    ->withPreparedSets(
        true, // deadCode
        true, // codeQuality
        true, // codingStyle
        false,
        false,
        true, // naming
    )
    ->withPhpSets(
        php81: true
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_100
    ])
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/test'])
    ->withRootFiles()
    ->withImportNames()
    ->withSkip([
        FirstClassCallableRector::class
    ]);
