<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $cnt */
$cnt = require_once __DIR__ . '/bootstrap.php';

return ConsoleRunner::createHelperSet($cnt->get(EntityManager::class));
