<?php

use Rector\Config\RectorConfig;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;

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
        false,
        false,
        false,
        false,
        true, // php73
    )
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/test'])
    ->withRootFiles()
    ->withImportNames()
    ->withSkip([
        CallableThisArrayToAnonymousFunctionRector::class,
    ]);
