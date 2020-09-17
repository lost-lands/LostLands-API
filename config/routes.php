<?php declare(strict_types=1);

use Slim\App;

return function (App $app) {

    $app->get('/', \App\Action\HomeAction::class);
    $app->get('/api', \App\Action\HomeApiAction::class);

};
