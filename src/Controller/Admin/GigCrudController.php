<?php

namespace App\Controller\Admin;

use App\Entity\Gig;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GigCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gig::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield DateTimeField::new('date')->setFormat('Y-MM-dd HH:mm')->renderAsChoice();
    }
}
