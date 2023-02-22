<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use DateTimeImmutable;
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

    #[Route('/{slug}', name: 'app_post_show', methods: ['GET', 'POST'])]
    public function show(string $slug, PostRepository $postRepository, CommentRepository $commentRepository, Request $request): Response
    {
        $post = $postRepository->findWithComments($slug);
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new DateTimeImmutable());
            $comment->setPost($post);
            $notice = '';

            if ($this->isGranted('ROLE_MODERATOR')) {
                $comment->setIsApproved(true);
                $notice = 'Your comment has been added';
            } else {
                $notice = 'Your comment is pending approval';
            }

            $commentRepository->save($comment, true);

            $this->addFlash(
                'notice',
                $notice
            );

            return $this->redirectToRoute('app_post_show', ['slug' => $post->getSlug()]);
        }

        return $this->renderForm('post/show.html.twig', [
            'post' => $post,
            'form' => $form
        ]);
    }
}
