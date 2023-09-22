<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Repository\FormateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateurs', name: 'globalFormateur')]
    public function index(FormateurRepository $formateurRepository): Response
    {
        $formateurs = $formateurRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    #[Route('/formateur/{id}', name: 'detailFormateur')]
    public function formateurDetail(Formateur $formateur): Response
    {
        return $this->render('formateur/detail.html.twig', [
            'formateur' => $formateur,
        ]);
    }
}
