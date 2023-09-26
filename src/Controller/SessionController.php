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
        $sessionsAVenir = $sessionRepository->findSessionsAVenir();
        $sessionsEnCours = $sessionRepository->findSessionsEnCours();
        $sessionsFinies = $sessionRepository->findSessionsFinies();
        $currentDate = new \DateTime;
        $currentDate = $currentDate->format("Y-m-D");


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
            'sessionsAVenir' => $sessionsAVenir,
            'sessionsEnCours' => $sessionsEnCours,
            'sessionsFinies' => $sessionsFinies,
            'currentDate' => $currentDate
            // 'arrayCount' => $arrayCount,
        ]);


    }

    #[Route('/session/{id}/delete', name: 'deleteSession')]
    public function sessionDelete(Session $session, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('globalSession');
    }


    #[Route('/session/new', name: 'newSession')]
    #[Route('/session/{id}/edit', name: 'editSession')]
    public function new(Session $session = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($session === null)
        {
            $session = new Session();            
        }
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

    #[Route('/session/{id}/delete', name: 'deleteSession')]
    public function sessionDelete(Session $session, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('globalSession');
    }

    #[Route('/session/{id}', name: 'detailSession')]
    public function sessionDetail(Session $session, SessionRepository $sessionRepo): Response
    {
        $stagiairesNonInscrits = $sessionRepo->findNonInscrits($session->getId());
        $modulesnonconcernes = $sessionRepo->findModulesNonConcernes($session->getId());
        return $this->render('session/detail.html.twig', [
            'session' => $session,
            'stagiairesNonInscrits' => $stagiairesNonInscrits,
            'modulesnonconcernes' => $modulesnonconcernes
        ]);
    }
}
