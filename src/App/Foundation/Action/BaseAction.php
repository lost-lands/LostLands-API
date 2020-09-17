<?php declare(strict_types=1);
/**
 * BaseAction Class
 *
 * Contains basic utilities and configurations used by all actions.
 */

namespace App\Foundation\Action;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseAction
{
    /**
     * @var \Slim\Views\Twig
     */
    protected $twig;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * BaseAction constructor.
     *
     * @access  public
     * @param   \Slim\Views\Twig                                  $twig
     * @param   \Symfony\Component\HttpFoundation\Session\Session $session
     */
    public function __construct(Twig $twig, Session $session)
    {
        $this->twig     = $twig;
        $this->session  = $session;
    }

    public function render(ResponseInterface $response, string $template, array $args = []) : ResponseInterface
    {
        return $this->twig->render($response, 'home.twig', []);
    }
}
