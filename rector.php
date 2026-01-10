<?php

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Array_\ArrayToFirstClassCallableRector;

return RectorConfig::configure()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        naming: true,
    )
    ->withPhpSets(
        php81: true
    )
    ->withComposerBased(phpunit: true)
    ->withPaths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/test'])
    ->withRootFiles()
    ->withImportNames(removeUnusedImports: true)
    ->withSkip([
        ArrayToFirstClassCallableRector::class,
    ]);
