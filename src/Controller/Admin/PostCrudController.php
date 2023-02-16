<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewShow = Action::new('Show')
            ->setCssClass('btn btn-success')
            ->setHtmlAttributes(['type' => 'button'])
            ->linkToRoute('app_post_show', fn (Post $post) => [
                'slug' => $post->getSlug()
            ]);
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->addCssClass('btn btn-primary');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->addCssClass('btn btn-danger ms-2 text-white');
            })
            ->add(Crud::PAGE_INDEX, $viewShow);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setDefaultSort([
                'author.username' => 'ASC',
            ])
            ->setPageTitle('index', 'Approved posts');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')->setColumns(6),
            AssociationField::new('author')->onlyOnIndex(),
            AssociationField::new('category')->setColumns(6),
            BooleanField::new('isApproved')->hideOnIndex(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            DateTimeField::new('updatedAt')->onlyOnIndex(),
            TextEditorField::new('content')->onlyOnForms()->setColumns(12)
        ];
    }
}
