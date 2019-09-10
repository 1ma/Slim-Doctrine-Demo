<?php

declare(strict_types=1);

use UMA\DIC\Container;
use UMA\DoctrineDemo\DI;

require_once __DIR__ . '/vendor/autoload.php';

define('APP_ROOT', __DIR__);

if (!file_exists(APP_ROOT . '/settings.php')) {
    copy(APP_ROOT . '/settings_devel.php', APP_ROOT . '/settings.php');
}

$cnt = new Container(require __DIR__ . '/settings.php');

$cnt->register(new DI\Doctrine());
$cnt->register(new DI\Slim());

return $cnt;
