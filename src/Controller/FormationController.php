<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('profile/formation', name: 'globalFormation')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy([], ["intitule" => "ASC"]);
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    #[Route('admin/formation/new', name: 'newFormation')]
    #[Route('admin/formation/{id}/edit', name: 'editFormation')]
    public function new(Formation $formation = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($formation === null) {
            $formation = new Formation();
        }
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $formation = $form->getData();
                $entityManager->persist($formation); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('globalFormateur'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("formation/new.html.twig", ['formNewFormation' => $form, 'edit' => $formation->getId()]);
    }

    #[Route('admin/formation/{id}/delete', name: 'deleteFormation')]
    public function formationDelete(Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($formation);
        $entityManager->flush();
        return $this->redirectToRoute('globalFormation');
    }

    #[Route('profile/formation/{id}', name: 'detailFormation')]
    public function formationDetail(Formation $formation): Response
    {
        return $this->render('formation/detail.html.twig', [
            'formation' => $formation,
        ]);
    }
}
