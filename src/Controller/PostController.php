<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PostRepository;
use App\Entity\Post;

class PostController extends AbstractController
{
    /**
     * Renders a list of posts.
     *
     * @param PostRepository $postRepository The post repository.
     * @return Response The response object.
     *
     */
    #[Route('/lista', name: 'post_list')]
    public function list(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('post/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * Deletes a post.
     *
     * @param Request $request The request object.
     * @param Post $post The post to be deleted.
     * @param PostRepository $postRepository The post repository.
     * @return Response The response object.
     */
    #[Route('/delete/{id}', name: 'post_delete', methods: ["POST"])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $postRepository->deletePost($post);

        $this->addFlash('success', 'Post was successfully deleted.');

        return $this->redirectToRoute('post_list');
    }
}
