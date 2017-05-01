<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Performance\Domain\UseCase\SignUp;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegisterController
{
    /**
     * @var \Twig_Environment
     */
    private $template;

    /**
     * @var UrlGeneratorInterface
     */
    private $url_generator;

    /**
     * @var SignUp
     */
    private $useCase;

    public function __construct(\Twig_Environment $templating, UrlGeneratorInterface $url_generator, SignUp $useCase) {
        $this->template = $templating;
        $this->url_generator = $url_generator;
        $this->useCase = $useCase;
    }

    public function get()
    {
        return new Response($this->template->render('register.twig'));
    }

    public function post(Request $request)
    {
    	$username = $request->request->get('username');
    	$password = $request->request->get('password');

    	$this->useCase->execute($username, $password);

        return new RedirectResponse($this->url_generator->generate('login'));
    }
}