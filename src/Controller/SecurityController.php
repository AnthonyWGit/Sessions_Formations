<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CredentialsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('globalSession');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/modifyCredentials/{id}', name: 'modifyCredentials')]
    public function mod(User $user, Request $request, EntityManagerInterface $entityManager) : Response
    { 
        if(!$this->getUser()){

            return $this->redirectToRoute('app_login');

        }
        $form = $this->createForm(CredentialsFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Les informations de votre compte ont bien été modifiées'
            );

            return $this->redirectToRoute('globalSession');
        }
        return $this->render('security/credentials.html.twig', [

            'form' => $form

        ]);

    }

    #[Route(path: '/profile', name: 'app_profile')]
    public function profile()
    { 
        return $this->render('security/profile.html.twig');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    { 
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
