<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/categorie/new', name: 'newCategorie')]
    #[Route('/categorie/{id}/edit', name: 'editCategorie')]
    public function new_edit(Categorie $categorie = null, Request $request, EntityManagerInterface $entityManager): Response
    {//Initialized at null so when categort doesn't exist it'll create a new one
        // creates a task object and initializes some data for this example

        if (!$categorie)
        {
            $categorie = new Categorie;
        }

        $form = $this->createForm(CategorieType::class, $categorie );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $categorie = $form->getData();
                $entityManager->persist($categorie); //traditional prepare / execute in SQL
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('globalCategorie'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("categorie/new.html.twig", ['formNewCategorie' => $form]);
    }
   
    #[Route('/categorie/{id}/delete', name: 'deleteCategorie')]
    public function categorieDelete(Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categorie);
        $entityManager->flush();
        $this->redirectToRoute('globalCategorie');
    }

    #[Route('/categorie/{id}', name: 'detailCategorie')]
    public function categorieDetail(Categorie $categorie): Response
    {
        return $this->render('categorie/detail.html.twig', [
            'categorie' => $categorie,
        ]);
    }


}