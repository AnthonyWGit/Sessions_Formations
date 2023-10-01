<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Programme;
use App\Entity\ModuleSession;
use App\Form\ModuleSessionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ModuleSessionRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;

class ModuleSessionController extends AbstractController
{

    #[Route('profile/modulesession', name: 'globalModuleSession')]
    public function index(ModuleSessionRepository $moduleSessionRepository): Response
    {
        $modulesSession = $moduleSessionRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('module_session/index.html.twig', [
            'modulesSession' => $modulesSession,
        ]);
    }
    #[Route('profile/modulesession/filter', name: 'filterModuleSession')]
    public function filter(
        Request $request,
        ModuleSessionRepository $moduleSessionRepository,
        EntityManagerInterface $entityManager,
    ): JsonResponse 
    {
        $searchTerm = $request->query->get('searchTerm');
        $filteredModules = $moduleSessionRepository->findBy(["nom" => $searchTerm], ["nom" => "ASC"]);
            // Create an array to store the serialized modules
    $serializedModules = [];

    foreach ($filteredModules as $module) {
        // Add the 'nom' property to each module
        $serializedModule = [
            'nom' => $module->getNom(),  // Replace with the actual method to retrieve the 'nom' property
            'categorie' => $module->getCategorie()->getNomCategorie(),
        ];
        $serializedModules[] = $serializedModule;
    }
        // Retrieve the filtered modules data from the repository

    
        // Return the JSON response
        return new JsonResponse(['modules' => $serializedModules]);
    }


    #[Route('admin/modulesession/new', name: 'newModuleSession')]
    #[Route('admin/modulesession/{id}/edit', name: 'editModuleSession')]
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

    #[Route('admin/modulesession/{id}/delete', name: 'deleteModuleSession')]
    public function moduleSessionDelete(ModuleSession $modulesession, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($modulesession);
        $entityManager->flush();
        return $this->redirectToRoute('globalModuleSession');
    }

  
}

