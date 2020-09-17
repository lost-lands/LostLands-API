<?php
declare(strict_types=1);


namespace App\Foundation\Middleware;

use App\Foundation\Factory\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
            ->addFileHandler('errors.log')
            ->createInstance('error_handler_middleware');
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $errorTypes = E_ALL;

        // Set custom php error handler.
        set_error_handler(
            function ($errno, $errstr, $errfile, $errline) {
                switch ($errno) {
                    case E_USER_ERROR:
                        $this->logger->error(
                            "Error number [$errno] $errstr on line $errline in file $errfile"
                        );
                    break;

                    case E_USER_WARNING:
                        $this->logger->warning(
                            "Error number [$errno] $errstr on line $errline in file $errfile"
                        );
                    break;
                    default:
                        $this->logger->notice(
                            "Error number [$errno] $errstr on line $errline in file $errfile"
                        );
                }
                return true;
            },
            $errorTypes
        );

        return $handler->handle($request);
    }
}
