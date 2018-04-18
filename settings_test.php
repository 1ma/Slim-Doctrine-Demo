<?php

declare(strict_types=1);

// settings for running the PHPUnit tests

return [
    'settings' => [
        'displayErrorDetails' => true,

        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => APP_ROOT . '/var/doctrine',
            'metadata_dirs' => [APP_ROOT . '/src/Domain'],
            'connection' => [
                'driver' => 'pdo_sqlite',
                'memory' => true
            ]
        ]
    ]
];
