<?php

namespace Performance\Domain;

class Article
{
    /**
     * @var int $id
     */
	private $id;

    /**
     * @var string $title
     */
	private $title;

    /**
     * @var string $content
     */
    private $content;

    /**
     * @var Author $author
     */
	private $author;

    /**
     * @var array $tags
     */
	private $tags;

    /**
     * @var int $created_at
     */
	private $created_at;

	public static function write($title, $content, Author $author) {
		$article = new Article();
		$article->title = $title;
		$article->content = $content;
		$article->author = $author;
		$article->created_at = (new \DateTime())->getTimestamp();

		return $article;
	}

	public function edit($title, $content, $author) {
		$this->title = $title;
		$this->content = $content;
		$this->author = $author;
	}

	public function getId() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getContent() {
		return $this->content;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getTags() {
		return $this->tags;
	}

	public function getDate() {
		return $this->created_at;
	}
}