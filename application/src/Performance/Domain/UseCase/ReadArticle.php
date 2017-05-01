<?php

namespace Performance\Domain\UseCase;

use Performance\Domain\ArticleRepository;

class ReadArticle
{
    /**
     * @var ArticleRepository
     */
	private $articleRepository;

    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    public function execute($article_id) {
    	return $this->articleRepository->findOneById($article_id);
    }
}