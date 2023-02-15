<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
class PostApprovedCrudController extends PostCrudController
{
  public static function getEntityFqcn(): string
  {
    return Post::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return parent::configureCrud($crud)->setPageTitle('index', 'Approved posts');
  }

  public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
  {
    return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
      ->andWhere('entity.isApproved = :approved')
      ->setParameter('approved', true);
  }
}
