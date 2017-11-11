<?php

// settings for development

return [
    'settings' => [
        'displayErrorDetails' => true,

        'doctrine' => [
            'paths' => [APP_ROOT . '/src/Domain'],
            'conn' => [
                'driver' => 'pdo_sqlite',
                'path' => APP_ROOT . '/var/database.sqlite'
            ]
        ]
    ]
];
