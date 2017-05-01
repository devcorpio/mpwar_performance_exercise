<?php

namespace Performance\Domain\UseCase;

use Performance\Domain\AuthorRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Login
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(AuthorRepository $authorRepository, SessionInterface $session) {
        $this->authorRepository = $authorRepository;
        $this->session = $session;
    }

    public function execute($username, $plainTextPassword) {
        $author = $this->authorRepository->findOneByUsername($username);

        if ($author) {
            if ($author->verifyPassword($plainTextPassword)) {
                $this->session->set('author_id', $author->getId());

                return true;
            }
        }

        return false;
    }
}