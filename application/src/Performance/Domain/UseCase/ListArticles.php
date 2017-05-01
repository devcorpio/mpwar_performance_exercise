<?php

namespace Performance\Domain\UseCase;

use Performance\Domain\ArticleRepository;

class ListArticles
{
    /**
     * @var ArticleRepository
     */
	private $articleRepository;

    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    public function execute() {
    	return $this->articleRepository->findAll();
    }
}