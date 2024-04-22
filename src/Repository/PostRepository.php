<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Deletes a post from the database.
     *
     * @param Post $post The post to be deleted.
     * @return void
     */
    public function deletePost(Post $post): void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }

    /**
     * Saves or updates a post based on an existing check by post ID.
     * @param int $id ID of the post from the external data source.
     * @param string $title Title of the post.
     * @param string $body Body content of the post.
     * @param Author $author Author entity associated with the post.
     * @return Post The saved or updated post entity.
     */
    public function saveOrUpdatePost(int $id, string $title, string $body, Author $author): Post
    {
        $post = $this->find($id);
        if (!$post) {
            $post = new Post();
            $post->setId($id);
        }

        $post->setTitle($title);
        $post->setBody($body);
        $post->setAuthor($author);

        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();

        return $post;
    }
}
