<?php declare(strict_types=1);

namespace App\Action;

use App\Foundation\Action\ApiAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeApiAction extends ApiAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $data = ['message' => 'Hello, world!'];
        return $this->render($response, $data);
    }
}
