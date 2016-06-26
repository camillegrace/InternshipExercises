<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        #'addContentLengthHeader' => false,
        'determineRouteBeforeAppMiddleware' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../../logs/app.log',
        ],
    ],
];