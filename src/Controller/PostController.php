<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/posts')]
class PostController extends AbstractController
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route('/{page<\d+>}', name: 'app_post_index', methods: ['GET'])]
    public function index(int $page = 1): Response
    {
        $queryBuilder = $this->postRepository->createOrderedByNewestQueryBuilder();

        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setCurrentPage($page);
        $pagerfanta->setMaxPerPage(12);

        return $this->render('post/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postRepository->save($post, true);

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    // #[Route('/{slug}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Post $post): Response
    // {
    //     $form = $this->createForm(PostType::class, $post);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->postRepository->save($post, true);

    //         return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('post/edit.html.twig', [
    //         'post' => $post,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{slug}', name: 'app_post_delete', methods: ['POST'])]
    // public function delete(Request $request, Post $post): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
    //         $this->postRepository->remove($post, true);
    //     }

    //     return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    // }
}
