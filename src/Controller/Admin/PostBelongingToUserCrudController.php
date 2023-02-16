<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
class PostBelongingToUserCrudController extends PostCrudController
{
  public static function getEntityFqcn(): string
  {
    return Post::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return parent::configureCrud($crud)->setPageTitle('index', 'My posts');
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('title')->setColumns(6),
      BooleanField::new('isApproved')->renderAsSwitch(false)->onlyOnIndex(),
      AssociationField::new('category')->setColumns(6),
      DateTimeField::new('createdAt')->onlyOnIndex(),
      DateTimeField::new('updatedAt')->onlyOnIndex(),
      TextEditorField::new('content')->onlyOnForms()->setColumns(12)
    ];
  }

  public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
  {
    return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
      ->andWhere('entity.author = :author')
      ->setParameter('author', $this->getUser());
  }
}
