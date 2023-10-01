<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgrammeController extends AbstractController
{
    #[Route('profile/programmes', name: 'app_programme')]
    public function index(ProgrammeRepository $programmeRepository): Response
    {
        $programme = $programmeRepository->findBy([], ["nbjours" => "ASC"]);
        return $this->render('programme/index.html.twig', [
            'programmes' => $programme,
        ]);
    }

    #[Route('admin/programme/new', name: 'newProgramme')]
    #[Route('admin/programme/{id}/edit', name: 'editProgramme')]
    public function new(Programme $programme = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($programme === null) {
            $programme = new Programme();
        }
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $programme = $form->getData();
                $entityManager->persist($programme); //traditional prepare / execute in SQL
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('globalModuleSession'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("programme/new.html.twig", ['formNewProgramme' => $form]);
    }

    #[Route('admin/programme/{id}/delete', name: 'deleteProgramme')]
    public function formateurDelete(Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($programme);
        $entityManager->flush();
        return $this->redirectToRoute('globalModuleSession');
    }
}
