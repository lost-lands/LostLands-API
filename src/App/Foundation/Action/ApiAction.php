<?php declare(strict_types=1);
/**
 * ApiAction Class
 *
 * Contains basic utilities and configurations used by all API actions,
 * for when we want to output json instead of render a twig template.
 */

namespace App\Foundation\Action;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ApiAction
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * ApiAction constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Session\Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function render(ResponseInterface $response, array $data) : ResponseInterface
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
