<?php

namespace App\Controller;

use App\Repository\ModuleSessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleSessionController extends AbstractController
{
    #[Route('/modulesession', name: 'globalModuleSession')]
    public function index(ModuleSessionRepository $moduleSessionRepository): Response
    {
        $modulesSession = $moduleSessionRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('module_session/index.html.twig', [
            'modulesSession' => $modulesSession,
        ]);
    }
}
