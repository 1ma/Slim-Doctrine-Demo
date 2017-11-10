<?php

declare(strict_types=1);

use Slim\App;
use Slim\Container;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../bootstrap.php';

/** @var App $app */
$app = $cnt[App::class];
$app->run();
