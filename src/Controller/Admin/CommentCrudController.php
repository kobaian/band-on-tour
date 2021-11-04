<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Gig Comment')
            ->setEntityLabelInPlural('Gig Comments')
            ->setSearchFields(['author_id', 'text'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function createEntity(string $entityFqcn)
    {
        $comment = new Comment();
        $comment->setCreatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));

        return $comment;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('gig'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('gig');
        yield NumberField::new('author_id');
        yield TextareaField::new('text')
            ->hideOnIndex();
        yield DateTimeField::new('createdAt')
            ->hideOnForm();
    }
}
