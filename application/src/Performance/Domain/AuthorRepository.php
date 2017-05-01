<?php

namespace Performance\Domain;

interface AuthorRepository
{
	public function save(Author $author);

    /**
     * @param $username
     * @return null|Author
     */
    public function findOneById($author_id);

	/**
	 * @param $username
	 * @return null|Author
	 */
	public function findOneByUsername($username);
}