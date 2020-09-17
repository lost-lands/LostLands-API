<?php declare(strict_types=1);

namespace App\Foundation\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;

final class HttpExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var \Psr\Http\Message\ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * HttpExceptionMiddleware constructor.
     *
     * @param \Psr\Http\Message\ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (HttpException $httpException) {

            // handle exception
            $statusCode     = $httpException->getCode();
            $response       = $this->responseFactory->createResponse()->withStatus($statusCode);
            $errorMessage   = sprintf('%s %s', $statusCode, strip_tags($response->getReasonPhrase()));
            $data = [
                'error' => $statusCode,
                'message' => $errorMessage
            ];
            $out = json_encode($data);

            $response->getBody()->write($out);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}
