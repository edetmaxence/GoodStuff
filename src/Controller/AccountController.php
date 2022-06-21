<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
