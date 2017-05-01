<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Response;
use Performance\Domain\UseCase\ListArticles;

class HomeController
{
    /**
     * @var \Twig_Environment
     */
	private $template;

    public function __construct(\Twig_Environment $templating, ListArticles $useCase) {
        $this->template = $templating;
        $this->useCase = $useCase;
    }

    public function get()
    {
        $articles = $this->useCase->execute();
        return new Response($this->template->render('home.twig', ['articles' => $articles]));
    }
}