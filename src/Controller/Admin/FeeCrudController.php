<?php

namespace App\Controller\Admin;

use App\Entity\Fee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fee::class;
    }

    /*public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('amount'),
            TextField::new('year'),
        ];
    }*/
}
