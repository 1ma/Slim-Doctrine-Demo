<?php

declare(strict_types=1);

// bootstrap file for public/index.php and cli-config.php

use UMA\DIC\Container;

require_once __DIR__ . '/vendor/autoload.php';


if (!file_exists(__DIR__ . '/settings.php')) {
    copy(__DIR__ . '/settings.php.dist', __DIR__ . '/settings.php');
}

return new Container(require __DIR__ . '/settings.php');
