<?php declare(strict_types=1);

return [
    'paths' => [
        // TODO: implement theming
        dirname(__DIR__) . '/resources/templates',
    ],
    'options' => [
        'cache_enabled' => (appEnv('app.environment', 'production') == 'production') ? true : false,
        'cache_path'    => dirname(__DIR__) . '/storage/cache/twig',
    ]
];
