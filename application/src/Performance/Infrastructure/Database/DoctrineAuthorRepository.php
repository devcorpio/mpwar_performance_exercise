<?php

namespace Performance\Infrastructure\Database;

use Doctrine\ORM\EntityRepository;
use Performance\Domain\Author;
use Performance\Domain\AuthorRepository;

class DoctrineAuthorRepository extends EntityRepository implements AuthorRepository
{
    public function findOneByUsername($username) {
        $sql =<<<QUERY
SELECT
    *
FROM
    authors
WHERE
    username = :username
QUERY;
        $conn = $this->_em->getConnection();
        $statement = $conn->prepare($sql);
        $statement->bindParam(':username', $username);
        $statement->execute();
        $userArray = $statement->fetch();
        $author = Author::fromArray($userArray);
        return $author;
    }

    public function save(Author $author) {
        $this->_em->persist($author);
        $this->_em->flush();
    }

    /**
     * @param $username
     * @return null|Author
     */
    public function findOneById($author_id)
    {
        return parent::findOneById($author_id);
    }
}