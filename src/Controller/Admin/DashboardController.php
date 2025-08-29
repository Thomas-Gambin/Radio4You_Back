<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Podcast;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\PodcastRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ArticleRepository $articleRepo,
        private PodcastRepository $podcastRepo,
        private UserRepository $userRepo,
    ) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('dashboard.html.twig', [
            'stats' => [
                'articles' => $this->articleRepo->count([]),
                'podcasts' => $this->podcastRepo->count([]),
                'users'    => $this->userRepo->count([]),
            ],

        ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Contenus');
        yield MenuItem::linkToCrud('Articles', 'fa fa-newspaper', Article::class)
            ->setBadge((string) $this->articleRepo->count([]));
        yield MenuItem::linkToCrud('Podcasts', 'fa fa-microphone', Podcast::class)
            ->setBadge((string) $this->podcastRepo->count([]));

        yield MenuItem::section('Administration');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class)
            ->setBadge((string) $this->userRepo->count([]));
    }
}
