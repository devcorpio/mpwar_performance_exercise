<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Performance\Domain\UseCase\ReadArticle;
use Predis\Client as PredisClient;

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

    /**
     * @var PredisClient
     */
    private $cache;

    public function __construct(\Twig_Environment $templating, ReadArticle $useCase, PredisClient $cache) {
        $this->template = $templating;
        $this->useCase = $useCase;
        $this->cache = $cache;
    }

    public function get($article_id)
    {
        if (!($article = $this->cache->get($article_id))) {
            $article = $this->useCase->execute($article_id);
            $this->cache->set($article_id, serialize($article));
        } else {
            $article = unserialize($article);
        }

        if (!$article) {
            $this->cache->del($article_id);
            throw new HttpException(404, "Article $article_id does not exist.");
        }

        $this->cache->zincrby('globalranking', 1, serialize($article));

        return new Response($this->template->render('article.twig', ['article' => $article]));
    }
}