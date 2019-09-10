<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;

/** @var ContainerInterface $cnt */
$cnt = require_once __DIR__ . '/../bootstrap.php';

/** @var App $app */
$app = $cnt->get(App::class);
$app->run();
