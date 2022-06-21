<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(ArticleRepository $articleRepository): Response
    {
        // Pour afficher tous les articles 
        $articles = $articleRepository->findBy(['owner' => $this->getUser()]);
        //dd($articles);

       // Pour afficher tous les articles
        /* $articles = $articleRepository->findAll(); */
      
        return $this->render('account/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/account/edit/{id}', name: 'edituser', requirements: ['id' => '\d+'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            
            $this->addFlash('success', 'Votre Compte est bien été modifié !');

            return $this->redirectToRoute('app_account');
            
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
