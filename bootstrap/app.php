<?php declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\App;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(dirname(__DIR__) . '/config/container.php');
$container = $containerBuilder->build();
$app = $container->get(App::class);
(require dirname(__DIR__) . '/config/routes.php')($app);
(require dirname(__DIR__) . '/config/middleware.php')($app);
return $app;
