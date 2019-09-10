<?php

declare(strict_types=1);

// bootstrap file for the PHPUnit test suite

use UMA\DIC\Container;
use UMA\DoctrineDemo\DI;

require_once __DIR__ . '/../vendor/autoload.php';


$testingSettings = require __DIR__ . '/../settings.php.dist';

// Alter Doctrine settings so it uses a transient in-memory database
unset($testingSettings['settings']['doctrine']['connection']['path']);
$testingSettings['settings']['doctrine']['connection']['memory'] = true;


$cnt = new Container($testingSettings);

$cnt->register(new DI\Doctrine());
$cnt->register(new DI\Slim());

// In this case $cnt is not returned, rather it will live as a global variable
// at $GLOBALS['cnt'] during the whole execution of the test suite. The same
// applies to the $testingSettings array.
