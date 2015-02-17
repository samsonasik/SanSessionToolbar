<?php

chdir(__DIR__);

$loader = include './../vendor/autoload.php';
$loader->add('SanSessionToolbarTest', __DIR__ .'/SanSessionToolbarTest');
