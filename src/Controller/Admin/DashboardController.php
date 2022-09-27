<?php

namespace App\Controller\Admin;

use App\Entity\Department;
use App\Entity\Description;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(DescriptionCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    // #[Route('/admin')]
    // public function index(): Response
    // {
    //     return $this->render('admin/my-dashboard.html.twig', []);
    // }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            // ->setName($user->getId())
            // use this method if you don't want to display the name of the user
            // ->setAvatarUrl('https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Ham_%284%29.jpg/440px-Ham_%284%29.jpg');
        ;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->renderSidebarMinimized()
            ->setTitle('Devops Project')
            // ->setFaviconPath('https://img.freepik.com/premium-photo/astronaut-outer-open-space-planet-earth-stars-provide-background-erforming-space-planet-earth-sunrise-sunset-our-home-iss-elements-this-image-furnished-by-nasa_150455-16829.jpg?w=2000');
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Departments', 'fas fa-users', Department::class);
        yield MenuItem::linkToCrud('Descriptions', 'fas fa-comment', Description::class);
        yield MenuItem::linkToLogout('Logout', 'fas fa-door-open');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::NEW, 'ROLE_MODERATOR')
            ->setPermission(Action::EDIT, 'ROLE_MODERATOR')
            ->setPermission(Action::DELETE, 'ROLE_MODERATOR')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_MODERATOR')
        ;
    }
}
