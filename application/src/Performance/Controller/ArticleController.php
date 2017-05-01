<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Performance\Domain\UseCase\ReadArticle;

class ArticleController
{
    /**
     * @var \Twig_Environment
     */
    private $template;

    /**
     * @var ReadArticle
     */
    private $useCase;

    public function __construct(\Twig_Environment $templating, ReadArticle $useCase) {
        $this->template = $templating;
        $this->useCase = $useCase;
    }

    public function get($article_id)
    {
        $article = $this->useCase->execute($article_id);

        if (!$article) {
            throw new HttpException(404, "Article $article_id does not exist.");
        }

        return new Response($this->template->render('article.twig', ['article' => $article]));
    }
}