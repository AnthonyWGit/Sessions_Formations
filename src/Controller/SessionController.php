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

        foreach ($sessions as $session)
        {
            foreach ($session->getStagiaires() as $stagiaire)
            {
                $arrayCount[$session->getId()] = $session->getPlaces() - 1;
            }
        }
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
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
