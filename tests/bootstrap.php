<?php

use Slim\Container;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../bootstrap.php';

// override the database configuration
// with an in-memory sqlite setup
$cnt['db'] = function (): array {
    return [
        'driver' => 'pdo_sqlite',
        'memory' => true
    ];
};
