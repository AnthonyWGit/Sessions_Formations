<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Programme;
use App\Entity\ModuleSession;
use App\Form\ModuleSessionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ModuleSessionRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/modulesession/new', name: 'newModuleSession')]
    #[Route('/modulesession/{id}/edit', name: 'editModuleSession')]
    public function new(ModuleSession $modulesession = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($modulesession === null) {
            $modulesession = new ModuleSession();
        }
        $form = $this->createForm(ModuleSessionType::class, $modulesession);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $modulesession = $form->getData();
                $entityManager->persist($modulesession); //traditional prepare / execute in SQL
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('globalModuleSession'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("module_session/new.html.twig", ['formNewModuleSession' => $form]);
    }

    #[Route('/modulesession/{id}/delete', name: 'deleteModuleSession')]
    public function moduleSessionDelete(ModuleSession $modulesession, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($modulesession);
        $entityManager->flush();
        return $this->redirectToRoute('globalModuleSession');
    }
}
