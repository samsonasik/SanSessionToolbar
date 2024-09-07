<?php

use Rector\Config\RectorConfig;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;

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
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/test'])
    ->withRootFiles()
    ->withImportNames()
    ->withSkip([
        FirstClassCallableRector::class
    ]);
