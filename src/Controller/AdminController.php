<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginatorInterface ): Response
    {   
        $articles = $paginatorInterface->paginate(
            $articleRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
