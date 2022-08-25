<?php

namespace App\Controller\Admin;

use App\Entity\Department;
use App\Entity\User;
use App\Entity\Description;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Devops Project');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'app_home');

        yield MenuItem::subMenu('User-stuff', 'fa fa-user')
            ->setSubItems([
                MenuItem::linkToCrud('Users', 'fas fa-user', User::class),
                MenuItem::linkToCrud('Departments', 'fas fa-users', Department::class),
                MenuItem::linkToCrud('Descriptions', 'fas fa-comment', Description::class),
            ]);
        yield MenuItem::subMenu('Admin-stuff', 'fa fa-hammer')
            ->setSubItems([
                MenuItem::linkToCrud('Users', 'fas fa-user', User::class),
                MenuItem::linkToCrud('Departments', 'fas fa-users', Department::class),
                MenuItem::linkToCrud('Descriptions', 'fas fa-comment', Description::class),
            ]);

        yield MenuItem::linkToLogout('Logout', 'fas fa-door-open');

        yield MenuItem::linkToRoute('Test', 'fa fa-chart-bar', 'app_login');
    }
}
