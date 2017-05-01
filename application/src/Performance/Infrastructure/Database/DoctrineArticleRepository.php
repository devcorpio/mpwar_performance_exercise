<?php

namespace Performance\Infrastructure\Database;

use Doctrine\ORM\EntityRepository;
use Performance\Domain\Article;
use Performance\Domain\ArticleRepository;

class DoctrineArticleRepository extends EntityRepository implements ArticleRepository
{
    public function save(Article $article) {
        $this->_em->persist($article);
        $this->_em->flush();
    }

    /**
     * @param $article_id
     * @return null|Article
     */
    public function findOneById($article_id)
    {
        return parent::findOneById($article_id);
    }
}