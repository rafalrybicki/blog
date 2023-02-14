<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
class PostPendingApprovalCrudController extends PostCrudController
{
  public function configureCrud(Crud $crud): Crud
  {
    return $crud->setPageTitle('index', 'Unapproved posts');
  }

  public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
  {
    return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
      ->andWhere('entity.isApproved = :approved')
      ->setParameter('approved', false);
  }
}
