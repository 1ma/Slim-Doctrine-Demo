<?php

declare(strict_types=1);

use Slim\App;
use UMA\DIC\Container;
use UMA\DoctrineDemo\DI;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../bootstrap.php';

$cnt->register(new DI\Doctrine());
$cnt->register(new DI\Slim());

/** @var App $app */
$app = $cnt->get(App::class);
$app->run();
