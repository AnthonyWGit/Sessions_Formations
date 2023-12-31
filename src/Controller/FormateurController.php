<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('profile/formateurs', name: 'globalFormateur')]
    public function index(FormateurRepository $formateurRepository): Response
    {
        $formateurs = $formateurRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    #[Route('admin/formateur/new', name: 'newFormateur')]
    #[Route('admin/formateur/{id}/edit', name: 'editFormateur')]
    public function new(Formateur $formateur = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        if ($formateur === null) {
            $formateur = new Formateur();
        }
        $form = $this->createForm(FormateurType::class, $formateur );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
            {
                $formateur = $form->getData();
                $entityManager->persist($formateur); //traditional prepare / execute in SQL MANDATORY for sql equivalents to INSERT 
                $entityManager->flush();

                $this->addFlash // need to be logged as user to see the flash messages build-in Symfony
                (
                    'notice',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('globalFormateur'); //redirect to list stagiaires if everything is ok
            }
        
        return $this->render("formateur/new.html.twig", ['formNewFormateur' => $form, 'edit' => $formateur->getId()]);
    }

    #[Route('admin/formateur/{id}/delete', name: 'deleteFormateur')]
    public function formateurDelete(Formateur $formateur, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($formateur);
        $entityManager->flush();
        return $this->redirectToRoute('globalCategorie');
    }

    #[Route('profile/formateur/{id}', name: 'detailFormateur')]
    public function formateurDetail(Formateur $formateur): Response
    {
        return $this->render('formateur/detail.html.twig', [
            'formateur' => $formateur, 
        ]);
    }
}
