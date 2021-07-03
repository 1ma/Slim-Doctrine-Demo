<?php

declare(strict_types=1);

// This is a special configuration file that the vendor/bin/doctrine tool expects to find
// in the current working directory when you run it. It must be named 'cli-config.php' and return a HelperSet instance.
// For more information refer to the Doctrine documentation at https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/configuration.html#setting-up-the-commandline-tool

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use UMA\DIC\Container;
use UMA\DoctrineDemo\DI;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/bootstrap.php';

$cnt->register(new DI\Doctrine());

return ConsoleRunner::createHelperSet($cnt->get(EntityManager::class));
