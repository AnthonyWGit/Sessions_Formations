<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'globalCategorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findBy([], ["nomCategorie" => "ASC"]);
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'detailCategorie')]
    public function categorieDetail(Categorie $categorie): Response
    {
        return $this->render('categorie/detail.html.twig', [
            'categorie' => $categorie,
        ]);
    }
}