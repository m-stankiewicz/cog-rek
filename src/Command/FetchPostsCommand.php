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
    /**
     * The default name of the command.
     *
     * @var string
     */
    protected static $defaultName = 'app:fetch-posts';

    /**
     * The API data service.
     *
     * @var ApiDataService
     */
    private ApiDataService $apiDataService;

    /**
     * Constructor for the FetchPostsCommand class.
     *
     * @param ApiDataService $apiDataService The API data service.
     * @param EntityManagerInterface $entityManager The entity manager.
     */
    public function __construct(ApiDataService $apiDataService, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->apiDataService = $apiDataService;
        $this->entityManager = $entityManager;
    }

    /**
     * Executes the command to fetch posts and authors from an API and store them in the database.
     *
     * @param InputInterface $input The input interface.
     * @param OutputInterface $output The output interface.
     * @return int The command exit code.
     */
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