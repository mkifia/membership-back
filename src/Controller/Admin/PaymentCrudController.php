<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Payment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

use function Symfony\Component\Translation\t;

class PaymentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Payment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('member', t('Member'))
                ->setCrudController(MemberCrudController::class)->hideOnDetail(),
            NumberField::new('year', t('Year'))->setThousandsSeparator(''),
            NumberField::new('amount', t('Amount'))->setNumDecimals(2)->setFormTypeOptions([
                'grouping' => true,
                'scale' => 2,
                'rounding_mode' => \NumberFormatter::ROUND_HALFUP,
            ]),
            ChoiceField::new('currency', t('Currency'))
            ->setChoices([
                'EUR' => 'EUR',
                'USD' => 'USD',
            ])->hideOnDetail(),
            ChoiceField::new('method', t('Method'))->hideOnDetail()
            ->setChoices([
                'Cash' => 'cash',
                'Check' => 'check',
                'Transfer' => 'transfer',
                'Card' => 'card',
            ]),

            TextEditorField::new('comment', t('Comment'))->hideOnDetail(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/detail', 'admin/payment/detail.html.twig')
            ->showEntityActionsInlined()
            ->setFormThemes(['admin/payment/form.html.twig', '@EasyAdmin/crud/form_theme.html.twig'])
            ->setPaginatorPageSize(50);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE);
    }
}
