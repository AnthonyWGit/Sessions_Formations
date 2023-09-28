<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Entity\ModuleSession;
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

    #[Route('admin/session/{id}/delete', name: 'deleteSession')]
    public function sessionDelete(Session $session, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('globalSession');
    }

    #[Route('/session_session/remove/stagiaire/{id}/{session}', name: 'removeStagiaire', priority: 1000 )] //Higher prio 
    public function removeStagiaire(Stagiaire $stagiaire, Session $session, EntityManagerInterface $entityManager): Response
    {
        $idToRedirect = [];
        $idToRedirect['id'] = $session->getId();
        var_dump($idToRedirect);
        $session->removeStagiaire($stagiaire);
        $entityManager->flush();
        return $this->redirectToRoute('detailSession', $idToRedirect);
    }

    #[Route('admin/session/new', name: 'newSession')]
    #[Route('admin/session/{id}/edit', name: 'editSession')]
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



    #[Route('session/{id}', name: 'detailSession')]
    public function sessionDetail(Session $session, SessionRepository $sessionRepo): Response
    {
        $totalNbJours = 0;
        foreach ($session->getProgrammes() as $prog)
        {
            $totalNbJours = $totalNbJours + $prog->getNbJours();
        }
        $stagiairesNonInscrits = $sessionRepo->findNonInscrits($session->getId());
        $modulesnonconcernes = $sessionRepo->findModulesNonConcernes($session->getId());
        return $this->render('session/detail.html.twig', [
            'session' => $session,
            'stagiairesNonInscrits' => $stagiairesNonInscrits,
            'modulesnonconcernes' => $modulesnonconcernes,
            'totalNbJours' => $totalNbJours
        ]);
    }

    #[Route('admin/session/addStagiaire/{id}/{session}', name: 'addStagiaire')]
    public function addStagiaire(Stagiaire $stagiaire, Session $session, EntityManagerInterface $entityManager): Response
    {
        $idToRedirect = [];
        $idToRedirect['id'] = $session->getId();
        $session->addStagiaire($stagiaire);
        $entityManager->flush();
        return $this->redirectToRoute('detailSession', $idToRedirect);
    }

    #[Route('admin/session/{id}/addModule/{session}', name: 'addModule')]
    public function addProgramme(Request $request, ModuleSession $modulesession, Session $session, EntityManagerInterface $entityManager): Response
    {
        //adding a new module means creatig a new programme
        $programme = new Programme;
        $idToRedirect = [];
        $idToRedirect['id'] = $session->getId();
        $nbjours = $request->request->get("number"); // get form field named "number"
        //setting new programme properties
        // $programme->setNbJours(intval($_POST["number"]));  That's what we would do in classic php 
        $programme->setNbjours($nbjours);
        $programme->setModuleSession($modulesession);
        $programme->setSession($session);
        $session->addProgramme($programme);
        $entityManager->persist($programme);
        $entityManager->flush();
        return $this->redirectToRoute('detailSession', $idToRedirect);
    }

    #[Route('admin/session/{id}/removeProgramme/{programme}', name: 'removeProgramme')]
    public function removeProgramme(Programme $programme, Session $session, EntityManagerInterface $entityManager): Response
    {
        $idToRedirect = [];
        $idToRedirect['id'] = $session->getId();
        $session->removeProgramme($programme);
        $entityManager->persist($programme);
        $entityManager->flush();
        return $this->redirectToRoute('detailSession', $idToRedirect);
    }
}
