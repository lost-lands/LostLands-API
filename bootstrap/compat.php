<?php declare(strict_types=1);
/**
 * Delete or rename this file after first run. Feel free to comment the call to it from /bootstrap/init.php.
 */

// Check PHP version.
$reqPhpVersion = '7.4';
$curPhpVersion = PHP_VERSION;

if (version_compare($curPhpVersion, $reqPhpVersion, '<')) {
    header('HTTP/1.1 500 Internal Server Error');
    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ERROR 500: Internal Server Error</title>
</head>
<body>
    <h1>ERROR 500: Internal Server Error</h1>
    <p>
        This application requires PHP version {$reqPhpVersion}, but the server is only running 
        PHP version {$curPhpVersion}! Please contact the administrator, and tell him to update his PHP!
    </p>
</body>
</html>
HTML;

    exit($html);
}

// Check for composer dependencies.
if (file_exists($composer = dirname(__DIR__) . '/vendor/autoload.php')) {
    require $composer;
} else {
    header('HTTP/1.1 500 Internal Server Error');
    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ERROR 500: Internal Server Error</title>
</head>
<body>
    <h1>ERROR 500: Internal Server Error</h1>
    <p>
        Application dependencies not installed! Please contact the administrator to install the dependencies!
    </p>
</body>
</html>
HTML;

    exit($html);
}
