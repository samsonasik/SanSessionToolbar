<?php

use Rector\Config\RectorConfig;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    ->withPreparedSets(
        codeQuality: true,
        naming: true,
        deadCode: true,
        codingStyle: true
    )
    ->withPhpSets(php73: true)
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/test'])
    ->withRootFiles()
    ->withImportNames()
    ->withSkip([
        CallableThisArrayToAnonymousFunctionRector::class,
    ]);
