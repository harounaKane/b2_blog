<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/article/{id}/show', name: 'app_article_show')]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            "article" => $article
        ]);
    }

    #[Route('/article/{id}/delete', name: 'app_article_delete')]
    public function delete(Article $article, EntityManagerInterface $manager)  {
        $manager->remove($article);

        $manager->flush();

        return $this->redirectToRoute('app_article_index');
    }

    #[Route("/article/new", name: "app_article_new")]
    public function new (EntityManagerInterface $manager, Request $request){
       $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $article->setCreatedAt( new \DateTimeImmutable() );
            
            try{
                $manager->persist($article);
                $manager->flush();

                $this->addFlash("success", "Article ajouté avec succes");

                return $this->redirectToRoute('app_article_index');
            }catch(Exception $e){
                
            }
        }

        return $this->render('article/new.html.twig', [
            "form" => $form
        ]);
    }
}
