<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CredentialsFormType;
use App\Form\deleteFormateurFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    #[Route(path: 'profile/modifyCredentials/{id}', name: 'modifyCredentials')]
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

    #[Route(path: 'admin/deleteFormateurProfile', name: 'deleteProfileFormateur')]
    public function deleteFormateur(Request $request, EntityManagerInterface $entityManager) : Response
    { 
        $username = $this->getUser()->getUsername();
        $form = $this->createForm(deleteFormateurFormType::class, null, ['ok' => $username]); //$username will be passed in the options array 
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve the selected users from the form
            $selectedUsers = $form->get('username')->getData();

            foreach ($selectedUsers as $user)
            {
                if ($user == $this->getUser())
                {   
                    return $this->redirectToRoute('app_error_page', ['code' => '403']);
                }
                else
                {
                    // $entityManager->remove($user);     
                    return $this->redirectToRoute('app_error_page', ['code' => '403']);               
                }
            }
            $entityManager->flush();
    
            $this->addFlash(
                'success',
                "Les utilisateurs ont été supprimés."
            );
    
            return $this->redirectToRoute('app_profile');
        }
    
        return $this->render('security/deleteFormateur.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: 'profile/self/{id}/deleteFormateurProfile', name: 'deleteProfileFormateurSelf')]
    public function deleteFormateurSelf(Request $request, User $user, EntityManagerInterface $entityManager) : Response
    { 
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'success',
            "Votre profil a été supprimé."
        );

        $request->getSession()->invalidate(); //avoiding You cannot refresh a user from the EntityUserProvider that does not contain an identifier. The user object has to be serialized with its own identifier mapped by Doctrine.
        $this->container->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute('app_logout');
    }


    #[Route(path: 'profile/view', name: 'app_profile')]
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
