<?php declare(strict_types=1);

$environment = appEnv('app.environment', 'production');

switch ($environment) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', '1');
    break;

    default:
        error_reporting(1);
        ini_set('display_errors', '0');
}

return [
    'display_error_details' => appEnv('error.display', false),
    'log_errors'            => appEnv('error.log', true),
    'log_error_details'     => appEnv('error.log_details', true),
];
