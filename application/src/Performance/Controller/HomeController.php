<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Response;
use Performance\Domain\UseCase\ListArticles;
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

    public function __construct(\Twig_Environment $templating, ListArticles $useCase, PredisClient $cache) {
        $this->template = $templating;
        $this->useCase = $useCase;
        $this->cache = $cache;
    }

    public function get()
    {
        $articles = $this->useCase->execute();
        $articlesGlobalTopRanking = $this->cache->zrevrange('globalranking', 0, 4);

        return new Response($this->template->render('home.twig', [
            'articles' => $articles,
            'articlesGlobalRanking' => $this->unserializeRanking($articlesGlobalTopRanking)
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