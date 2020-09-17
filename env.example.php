<?php declare(strict_types=1);
/**
 * Example of env.php file contents with default values set.
 *
 * Please use this file as a reference for configuring your application.
 */

// App Environment
$_ENV['app.environment'] = 'production';

// Database Connection example
$_ENV['db'] = [
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'port'      => 3306,
    'dbname'    => 'example',
    'user'      => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'driverOptions' => [
        PDO::ATTR_PERSISTENT            => false,
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES      => true,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
    ],
];
