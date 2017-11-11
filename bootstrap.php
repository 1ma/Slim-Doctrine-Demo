<?php

declare(strict_types=1);

use UMA\DoctrineDemo\Provider\Doctrine;
use UMA\DoctrineDemo\Provider\Slim;
use Slim\Container;

require_once __DIR__ . '/vendor/autoload.php';

define('APP_ROOT', __DIR__);

if (!file_exists(APP_ROOT . '/settings.php')) {
    copy(APP_ROOT . '/settings_devel.php', APP_ROOT . '/settings.php');
}

$cnt = new Container(require __DIR__ . '/settings.php');

$cnt->register(new Doctrine())
    ->register(new Slim());

return $cnt;
