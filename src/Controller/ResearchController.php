<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResearchController extends AbstractController
{
    #[Route('/research', name: 'app_research')]
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $search = $request->query->get('search');
        $articles = $articleRepository->findByResearch($search);

        return $this->render('research/index.html.twig', [
            'controller_name' => 'ResearchController',
            'articles' => $articles
        ]);
    }
}
