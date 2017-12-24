<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\Container;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/bootstrap.php';

ConsoleRunner::run(
    ConsoleRunner::createHelperSet($cnt[EntityManager::class])
);
