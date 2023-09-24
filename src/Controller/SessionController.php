<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/sessions', name: 'globalSession')]
    public function index(SessionRepository $sessionRepository): Response
    {

        $sessions = $sessionRepository->findBy([], ["titre" => "ASC"]);

        // foreach ($sessions as $session) Trying to do counting via controller  i get good arrays but i dunno how i can use it to say give index 0 to session id 1 etc.
        // {
        //     $placesRestantes = 0;

        //     foreach ($session->getStagiaires() as $stagiaire)
        //     {
        //         $placesRestantes = $placesRestantes + 1;
        //     }
        //     $arrayCount[$session->getId()] = $session->getPlaces() - $placesRestantes;
        // }

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
            // 'arrayCount' => $arrayCount,
        ]);
    }


    #[Route('/session/new', name: 'newSession')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        $session = new Session();
        $form = $this->createForm(SessionType::class , $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $session = $form->getData();
                $entityManager->persist($session); //traditional prepare / execute in SQL
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('globalSession'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("session/new.html.twig", ['formNewSession' => $form]);
    }


    #[Route('/session/{id}', name: 'detailSession')]
    public function sessionDetail(Session $session): Response
    {
        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
