<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToRoute('Retour sur le blog', 'fa fa-undo', 'app_home'),

            MenuItem::section(),

            MenuItem::subMenu('Articles', 'fa fa-newspaper')->setSubItems([
                MenuItem::linkToCrud('Catégories', 'fa fa-list', Category::class),
                MenuItem::linkToCrud('Tous les articles', 'fa fa-newspaper', Article::class),
            ]),

            MenuItem::section(),

            MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class),

            MenuItem::section(),

            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
        ];
    }
}
