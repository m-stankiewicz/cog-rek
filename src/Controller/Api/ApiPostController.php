<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PostRepository;

class ApiPostController extends AbstractController
{
    #[Route('/api/posts', name: 'api_posts', methods: ['GET'])]
    public function list(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->json($posts);
    }
}
