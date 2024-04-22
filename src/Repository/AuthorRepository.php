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

    public function findByName(string $name): ?Author
    {
        return $this->findOneBy(['name' => $name]);
    }
}
