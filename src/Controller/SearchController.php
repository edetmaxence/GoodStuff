<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'handleSearch')]
    public function handleSearch(Request $request, ArticleRepository $articleRepository,PaginatorInterface $paginatorInterface, CategoryRepository $categoryRepository)
    {
        $query = $request->query->get('query');
        if($query) {
            $articles = $paginatorInterface->paginate(
                $articleRepository->findArticlesByName($query),
                $request->query->getInt('page',1),6
            );
            
            $categories = $categoryRepository->findAll($query);
        }
        // dd($articles);

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
    
}
