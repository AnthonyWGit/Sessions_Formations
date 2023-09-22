<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleSessionController extends AbstractController
{
    #[Route('/module/session', name: 'app_module_session')]
    public function index(): Response
    {
        return $this->render('module_session/index.html.twig', [
            'controller_name' => 'ModuleSessionController',
        ]);
    }
}
