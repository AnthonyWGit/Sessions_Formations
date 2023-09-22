<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaires', name: 'globalStagiaire')]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        $stagiaires = $stagiaireRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    #[Route('/stagiaire/new', name: 'newStagiaire')]
    public function new(Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class , $stagiaire );

        return $this->render("stagiaire/new.html.twig", ['formNewStagiaire' => $form]);
    }


    #[Route('/stagiaire/{id}', name: 'detailStagiaire')]
    public function details(Stagiaire $stagiaire): Response
    {
        return $this->render('stagiaire/display.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }

}



