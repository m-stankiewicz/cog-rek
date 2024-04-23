<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * Saves an author if it does not already exist.
     *
     * @param int $id The ID of the author.
     * @param string $name The name of the author.
     * @return Author The saved or existing author.
     */
    public function saveAuthorIfNotExists(int $id, string $name): Author
    {
        $author = $this->find($id);
        if (!$author) {
            $author = new Author();
            $author->setId($id);
            $author->setName($name);
            $this->getEntityManager()->persist($author);
            $this->getEntityManager()->flush();
        }
        return $author;
    }

    /**
     * Finds an author by their name.
     *
     * @param string $name The name of the author.
     * @return Author|null The author object if found, or null if not found.
     */
    public function findByName(string $name): ?Author
    {
        return $this->findOneBy(['name' => $name]);
    }
}
