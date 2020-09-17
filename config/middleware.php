<?php declare(strict_types=1);

use App\Foundation\Middleware\SessionMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {

    // Rendering
    $app->addBodyParsingMiddleware();       // Parse json/xml/form data.

    // Sessions
    $app->add(SessionMiddleware::class);    // Session management.

    // Routing
    $app->add(BasePathMiddleware::class);   // Detect base path.
    $app->addRoutingMiddleware();           // Built-in Slim router.

    // Error Handling
    $app->add(ErrorMiddleware::class);      // Catch exceptions and errors.

};
