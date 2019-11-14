<?php

use LaminasDeveloperTools\Collector\AbstractCollector as LaminasDeveloperToolsAbstractCollector;
use ZendDeveloperTools\Collector\AbstractCollector as ZendDeveloperToolsAbstractCollector;

if (class_exists(LaminasDeveloperToolsAbstractCollector::class)) {
    class_alias(LaminasDeveloperToolsAbstractCollector::class, ZendDeveloperToolsAbstractCollector::class);
}
