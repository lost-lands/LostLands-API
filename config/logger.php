<?php declare(strict_types=1);

use Monolog\Logger;

return [
    'name'      => 'app',
    'path'      => dirname(__DIR__) . '/storage/logs',
    'file_name' => 'app.log',
    'level'     => Logger::DEBUG,
    'file_permission' => 0755,
];
