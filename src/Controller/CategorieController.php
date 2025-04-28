<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie_index')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        // recup toutes les catégorie
        $categories = $categorieRepository->findAll();
        
        return $this->render('categorie/index.html.twig', [
            "categories" => $categories
        ]);
    }

    #[Route("/categorie/show/{id}", name:"app_categorie_show")]
    public function show(Categorie $categorie){
        // $categorie = $categorieRepository->find($id);
        return $this->render('categorie/show.html.twig', ["categorie" => $categorie]);
    }
}
