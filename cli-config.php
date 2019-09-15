<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use UMA\DIC\Container;
use UMA\DoctrineDemo\DI;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/bootstrap.php';

$cnt->register(new DI\Doctrine());

return ConsoleRunner::createHelperSet($cnt->get(EntityManager::class));
