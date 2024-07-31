<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Fee;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }
}
