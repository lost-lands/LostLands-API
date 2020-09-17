<?php declare(strict_types=1);

use App\Foundation\Factory\LoggerFactory;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

$objects = [];

// Application settings
$objects['settings'] = function () {
    return require __DIR__ . '/settings.php';
};

// Application instance
$objects[App::class] = function (ContainerInterface $container) {
    AppFactory::setContainer($container);
    return AppFactory::create();
};

// Error middleware
$objects[ErrorMiddleware::class] = function (ContainerInterface $container) {

    // Configure error handler
    $app        = $container->get(App::class);
    $settings   = $container->get('settings')['error'];

    // Configure error log
    $loggerFactory  = $container->get(LoggerFactory::class);
    $logger         = $loggerFactory->addFileHandler('error.log')->createInstance('error');

    return new ErrorMiddleware(
        $app->getCallableResolver(),
        $app->getResponseFactory(),
        (bool)$settings['display_error_details'],
        (bool)$settings['log_errors'],
        (bool)$settings['log_error_details'],
        $logger
    );
};

// Detect base path
$objects[BasePathMiddleware::class] = function (ContainerInterface $container) {
    return new BasePathMiddleware($container->get(App::class));
};

// Logger
$objects[LoggerFactory::class] = function (ContainerInterface $container) {
    return new LoggerFactory($container->get('settings')['logger']);
};

// Twig templates
$objects[Twig::class] = function (ContainerInterface $container) {

    $settings = $container->get('settings')['twig'];

    $paths              = $settings['paths'];
    $options            = $settings['options'];
    $options['cache']   = $options['cache_enabled'] ? $options['cache_path'] : false;

    $twig = Twig::create($paths, $options);

    // Extensions go here //

    return $twig;

};

$objects[TwigMiddleware::class] = function (ContainerInterface $container) {
    return TwigMiddleware::createFromContainer(
        $container->get(App::class),
        Twig::class
    );
};

// sessions
$objects[Session::class] = function (ContainerInterface $container) {
    $settings = $container->get('settings')['session'];

    // check for CLI environment
    if (PHP_SAPI === 'cli') {
        return new Session(new MockArraySessionStorage());
    } else {
        return new Session(new NativeSessionStorage($settings));
    }
};

$objects[SessionInterface::class] = function (ContainerInterface $container) {
    return $container->get(Session::class);
};

// Database
$object[Connection::class] = function (ContainerInterface $container) {
    $config = new DoctrineConfiguration();
    $connectionParams = $container->get('settings')['db'];

    return DriverManager::getConnection($connectionParams, $config);
};

$object[PDO::class] = function (ContainerInterface $container) {
    return $container->get(Connection::class)->getWrappedConnection();
};

return $objects;
