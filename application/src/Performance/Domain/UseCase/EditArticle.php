<?php

namespace Performance\Domain\UseCase;

use Performance\Domain\ArticleRepository;
use Performance\Domain\AuthorRepository;
use Performance\Domain\Exception\Forbidden;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EditArticle
{
    /**
     * @var ArticleRepository
     */
	private $articleRepository;

    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @var SessionInterface
     */
	private $session;

    public function __construct(ArticleRepository $articleRepository, AuthorRepository $authorRepository, SessionInterface $session) {
        $this->articleRepository = $articleRepository;
        $this->authorRepository = $authorRepository;
        $this->session = $session;
    }

    public function execute($article_id, $title, $content) {
    	$author = $this->getAuthor();
    	$article = $this->articleRepository->findOneById($article_id);
    	$article->edit($title, $content, $author);
        $this->articleRepository->save($article);

        return $article;
    }

    private function getAuthor() {
        $author_id = $this->session->get('author_id');

        if (!$author_id) {
            throw new Forbidden('You must be logged in in order to write an article');
        }

        return $this->authorRepository->findOneById($author_id);
    }
}