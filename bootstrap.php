<?php

declare(strict_types=1);

use UMA\DoctrineDemo\Provider\Doctrine;
use UMA\DoctrineDemo\Provider\Slim;
use Slim\Container;

require_once __DIR__ . '/vendor/autoload.php';

define('APP_ROOT', __DIR__);

$cnt = new Container(require_once __DIR__ . '/settings.php');

$cnt->register(new Doctrine())
    ->register(new Slim());

return $cnt;
