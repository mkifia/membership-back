<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use function Symfony\Component\Translation\t;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->hideOnForm(),
            AssociationField::new('team', t('Team'))
                ->setCrudController(TeamCrudController::class),
            TextField::new('email', t('Email'))->hideOnIndex(),
            TextField::new('firstName', t('First Name')),
            TextField::new('lastName', t('Last Name')),
            ChoiceField::new('status', 'Status')
                ->setChoices([
                    'Suspended' => 'suspended',
                    'Active' => 'active',
                    'Overdue' => 'overdue',
                    'Deleted' => 'deleted',
                ])->hideOnIndex(),
            TextField::new('number', t('Number')),
            TextField::new('phone', t('Phone')),
            DateTimeField::new('bornAt', t('Born At'))->onlyOnDetail(),
            AssociationField::new('address', t('Address'))
                ->setCrudController(AddressCrudController::class)->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/detail', 'admin/member/detail.html.twig')
            ->showEntityActionsInlined()
            ->setFormThemes(['admin/member/form.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])
            ->setPaginatorPageSize(50);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('firstName')
            ->add('lastName')
            ->add('number')
            ->add('status')
            ->add('team')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE);
    }
}
