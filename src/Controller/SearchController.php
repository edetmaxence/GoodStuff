<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'handleSearch')]
    public function handleSearch(Request $request, ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        $query = $request->query->get('query');
        if($query) {
            $articles = $articleRepository->findArticlesByName($query);
            $categories = $categoryRepository->findAll($query);
        }
        // dd($articles);

        return $this->render('search/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
    
}
