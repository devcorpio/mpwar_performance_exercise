<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Performance\Domain\UseCase\Login;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AuthController
{
    /**
     * @var UrlGeneratorInterface
     */
    private $url_generator;

    /**
     * @var Login
     */
    private $useCase;

    public function __construct(UrlGeneratorInterface $url_generator, Login $useCase) {
        $this->url_generator = $url_generator;
        $this->useCase = $useCase;
    }

    public function post(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if ($this->useCase->execute($username, $password)) {
        	return new RedirectResponse($this->url_generator->generate('home'));
        } else {
        	return new RedirectResponse($this->url_generator->generate('login'));
        }
    }
}