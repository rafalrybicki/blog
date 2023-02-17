<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
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
    public function index(CategoryRepository $categories, Request $request, int $page = 1): Response
    {
        $queryBuilder = $this->postRepository->createOrderedByNewestQueryBuilder($request->query->get('category'));

        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setCurrentPage($page);
        $pagerfanta->setMaxPerPage(9);

        return $this->render('post/index.html.twig', [
            'pager' => $pagerfanta,
            'categories' => $categories->findAll()
        ]);
    }

    #[Route('/{slug}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
