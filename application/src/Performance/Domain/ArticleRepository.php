<?php

namespace Performance\Domain;

interface ArticleRepository
{
	public function save(Article $article);

	/**
	 * @param $article_id
	 * @return null|Article
	 */
	public function findOneById($article_id);

	public function findAll();
}