<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use function Symfony\Component\Translation\t;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', t('ID'))->hideOnForm(),
            TextField::new('street', t('Street')),
            TextField::new('suffix', t('Suffix')),
            TextField::new('city', t('City')),
            TextField::new('postalCode', t('Postal Code')),
            TextField::new('state', t('State')),
            TextField::new('country', t('Country')),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('street')
            ->add('suffix')
            ->add('city')
            ->add('postalCode')
            ->add('state')
            ->add('country')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/detail', 'admin/address/detail.html.twig')
            ->showEntityActionsInlined()
            ->setFormThemes(['admin/address/form.html.twig', '@EasyAdmin/crud/form_theme.html.twig']);
    }
}
