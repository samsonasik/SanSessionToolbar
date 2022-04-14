<?php

use Rector\Config\RectorConfig;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::NAMING,
        LevelSetList::UP_TO_PHP_73,
        SetList::DEAD_CODE,
        SetList::CODING_STYLE
    ]);

    $rectorConfig->paths([__DIR__ . '/config', __DIR__ . '/src', __DIR__ . '/test', __DIR__ . '/rector.php']);
    $rectorConfig->importNames();

    $rectorConfig->skip([
        CallableThisArrayToAnonymousFunctionRector::class,
    ]);
};
