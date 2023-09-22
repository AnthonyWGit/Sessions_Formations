<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Entity\Session;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
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
            'arrayCount' => $arrayCount,
        ]);
    }

    #[Route('/session/{id}', name: 'detailSession')]
    public function sessionDetail(Session $session): Response
    {
        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
