<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserFormType;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            
            $this->addFlash('success', 'Votre Compte est bien été enregistré !');
            
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'edituser', requirements: ['id' => '\d+'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            
            $this->addFlash('success', 'Votre Compte est bien été enregistré !');

            return $this->redirectToRoute('app_home');
            
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
