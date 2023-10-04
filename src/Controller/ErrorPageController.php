<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorPageController extends AbstractController
{
    #[Route('/error/{code}', name: 'app_error_page')]
    public function index(String $code = null): Response
    {
        if ($code != 404)
        {
            return $this->redirectToRoute('app_error_page_404');
        }
        return $this->render('error_page/index.html.twig', [
            'controller_name' => 'ErrorPageController',
            'code' => $code,
        ]);
    }

    #[Route('/error/404', name: 'app_error_page_404')]
    public function errorFourOFour(String $code): Response
    {   $code = 404;
        return $this->render('error_page/index.html.twig', [
            'controller_name' => 'ErrorPageController',
            'code' => $code,
        ]);
    }

}
