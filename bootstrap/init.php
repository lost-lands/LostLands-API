<?php declare(strict_types=1);

// Run compatibility tests.
if (file_exists($compat = __DIR__ . '/compat.php')) require $compat;

// Load environment configs.
if (file_exists($env_config = dirname(__DIR__) . '/env.php')) require $env_config;

// Load common functions.
require_once __DIR__ . '/common.php';

// Run the applicaton.
$app = require __DIR__ . '/app.php';

return $app;
