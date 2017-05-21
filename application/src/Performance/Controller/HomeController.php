<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Response;
use Performance\Domain\UseCase\ListArticles;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Predis\Client as PredisClient;

class HomeController
{
    /**
     * @var \Twig_Environment
     */
	private $template;

    /**
     * @var ListArticles
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

    public function __construct(\Twig_Environment $templating, ListArticles $useCase, PredisClient $cache, SessionInterface $session) {
        $this->template = $templating;
        $this->useCase = $useCase;
        $this->cache = $cache;
        $this->session = $session;
    }

    public function get()
    {
        $articles = $this->useCase->execute();
        $articlesGlobalTopRanking = $this->cache->zrevrange('globalranking', 0, 4);
        $articlesAuthTopRanking = [];

        if ($this->session->get('author_id')) {
            $articlesAuthTopRanking = $this->cache->zrevrange('userranking_'.$this->session->get('author_id'), 0, 4);
        }

        return new Response($this->template->render('home.twig', [
            'articles' => $articles,
            'articlesGlobalRanking' => $this->unserializeRanking($articlesGlobalTopRanking),
            'articlesAuthRanking' => $this->unserializeRanking($articlesAuthTopRanking)
        ]));
    }

    public function unserializeRanking($ranking)
    {
        $ranking = array_map(function($r) {
            return unserialize($r);
        }, $ranking);

        return $ranking;
    }
}