<?php

namespace App\Controller\Admin;

use App\Entity\Gig;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GigCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gig::class;
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        $lala = 0;
//        if (Crud::PAGE_DETAIL === $responseParameters->get('pageName')) {
//            $responseParameters->set('foo', '...');
//
//            // keys support the "dot notation", so you can get/set nested
//            // values separating their parts with a dot:
//            $responseParameters->setIfNotSet('bar.foo', '...');
//            // this is equivalent to: $parameters['bar']['foo'] = '...'
//        }

        return $responseParameters;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');

//        yield DateTimeField::new('createdAt')->renderAsNativeWidget();
        yield DateTimeField::new('date')->setFormat('Y-MM-dd HH:mm')->renderAsChoice();

//        $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
//            'html5' => true,
//            'years' => range(date('Y'), date('Y') + 5),
//                'widget' => 'single_text',
//            ]);
//        if (Crud::PAGE_EDIT === $pageName) {
//            yield $createdAt->setFormTypeOption('disabled', true);
//        } else {
//            yield $createdAt;
//        }
    }
}
