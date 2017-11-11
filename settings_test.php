<?php

// settings for running the PHPUnit tests

return [
    'settings' => [
        'displayErrorDetails' => true,

        'doctrine' => [
            'paths' => [APP_ROOT . '/src/Domain'],
            'conn' => [
                'driver' => 'pdo_sqlite',
                'memory' => true
            ]
        ]
    ]
];
