<?php

namespace App\Command;

use App\Service\ApiDataService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Author;
use App\Entity\Post;

class FetchPostsCommand extends Command
{
    protected static $defaultName = 'app:fetch-posts';
    private ApiDataService $apiDataService;

    public function __construct(ApiDataService $apiDataService, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->apiDataService = $apiDataService;
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $users = $this->apiDataService->fetchUsers();
        $posts = $this->apiDataService->fetchPosts();

        foreach ($users as $userData) {
            $author = $this->entityManager->getRepository(Author::class)->saveAuthorIfNotExists($userData['id'], $userData['name']);
        }

        foreach ($posts as $postData) {
            $author = $this->entityManager->getRepository(Author::class)->findOneById($postData['userId']);
            if (!$author) {
                $io->note('Author not found for user ID: ' . $postData['userId']);
                continue;
            }
            $this->entityManager->getRepository(Post::class)->saveOrUpdatePost($postData['id'], $postData['title'], $postData['body'], $author);
        }
        $this->entityManager->flush();

        $io->success('Posts and authors have been successfully fetched and stored.');

        return Command::SUCCESS;
    }
}