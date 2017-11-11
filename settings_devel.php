<?php

// settings for development

return [
    'settings' => [
        'displayErrorDetails' => true,

        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => APP_ROOT . '/var/doctrine',
            'metadata_dirs' => [APP_ROOT . '/src/Domain'],
            'connection' => [
                'driver' => 'pdo_sqlite',
                'path' => APP_ROOT . '/var/database.sqlite'
            ]
        ]
    ]
];
