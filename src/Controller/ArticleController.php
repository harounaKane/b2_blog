<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            "articles" => $articleRepository->findAll()
        ]);
    }

    #[Route('/article/{id}', name: 'app_article_show')]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            "article" => $article
        ]);
    }
}
