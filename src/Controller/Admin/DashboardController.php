<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();
        return $this->render('admin/index.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        $numberOfUnapproved = $this->postRepository->numberOfUnapproved();
        $number = $numberOfUnapproved > 0 ? '(' . $numberOfUnapproved . ')' : '';

        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Approved posts', 'fa fa-file-circle-check', Post::class)
            ->setController(PostCrudController::class)
            ->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud("Unapproved posts $number", 'fa fa-file-circle-question', Post::class)
            ->setController(PostPendingApprovalCrudController::class)
            ->setPermission('ROLE_MODERATOR');
        yield MenuItem::section();
        yield MenuItem::linkToUrl('Go to blog', 'fas fa-home', $this->generateUrl('app_post_index'));
    }
}
