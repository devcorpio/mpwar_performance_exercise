<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(\Twig_Environment $templating, ReadArticle $useCase, PredisClient $cache, SessionInterface $session) {
        $this->template = $templating;
        $this->useCase = $useCase;
        $this->cache = $cache;
        $this->session = $session;
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

        if ($this->session->get('author_id')) {
            $this->cache->zincrby('userranking_'.$this->session->get('author_id'), 1, serialize($article));
        }



        return new Response($this->template->render('article.twig', ['article' => $article]));
    }
}