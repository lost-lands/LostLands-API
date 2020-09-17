<?php
declare(strict_types=1);


namespace App\Action;

use App\Foundation\Action\ApiAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class InfoActon extends ApiAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $data = [
            'name'          => 'Lost Lands API',
            'version'       => '2.0.0-alpha',
            'author'        => 'CounterSanity',
            'copyright'     => 'Copyright 2020 Lost Lands Anarchy',
            'website'       => 'https://www.lostlands.co',
            'discord'       => 'https://invite.gg/lostlands',
            'documentation' => 'https://developer.lostlands.co/',
            'source'        => 'https://github.com/lost-lands/lostlands-api',
        ];

        return $this->render(
            $response,
            $data
        );
    }
}