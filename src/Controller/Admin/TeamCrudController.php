<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use function Symfony\Component\Translation\t;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/detail', 'admin/team/detail.html.twig')
            ->showEntityActionsInlined()
            ->setFormThemes(['admin/member/form.html.twig', '@EasyAdmin/crud/form_theme.html.twig']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->hideOnForm(),
            TextField::new('name', t('Name')),
            TextField::new('number', t('Number')),
            CollectionField::new('members', t('Members'))
                ->useEntryCrudForm()->setEntryIsComplex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_EDIT, Action::INDEX);
    }
}
