<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
            CollectionField::new('comments')->onlyOnIndex(),
            BooleanField::new('isApproved')->hideOnIndex(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            DateTimeField::new('updatedAt')->onlyOnIndex(),
            TextEditorField::new('content')->onlyOnForms()->setColumns(12)
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->innerJoin('entity.category', 'category')
            ->addSelect('category')
            ->innerJoin('entity.author', 'user')
            ->addSelect('user')
            ->innerJoin('entity.comments', 'comment')
            ->addSelect('comment');
    }
}
