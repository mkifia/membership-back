<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Entity\Admin;
use App\Entity\Fee;
use App\Entity\Member;
use App\Entity\Payment;
use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\Translation\t;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin/{_locale}', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->renderContentMaximized()
            ->setTranslationDomain('membership')
            ->setTitle(t('Membership Admin'))
            ->setLocales([
                'en' => '🇬🇧 English',
                'fr' => '🇵🇱 Français',
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard(t('Dashboard'), 'fa fa-home');
        yield MenuItem::linkToCrud(t('Fee'), 'fas fa-bank', Fee::class);
        yield MenuItem::linkToCrud(t('Team'), 'fas fa-people-group', Team::class);
        yield MenuItem::linkToCrud(t('Member'), 'fas fa-user', Member::class);
        yield MenuItem::linkToCrud(t('Admin'), 'fas fa-user-tie', Admin::class);
        yield MenuItem::linkToCrud(t('Payment'), 'fas fa-credit-card', Payment::class);
        yield MenuItem::linkToCrud(t('Address'), 'fas fa-map-location-dot', Address::class);
    }
}
