<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class AdminController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    #[Route('/admin', name: 'app_admin')]
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginatorInterface ): Response
    {   
        $success = $request->query->get('success');

        $articles = $paginatorInterface->paginate(
            $articleRepository->findAll(),
            $request->query->getInt('page', 1),
            7
        );

        return $this->render('admin/index.html.twig', [
            'articles' => $articles,
            'success' => $success
        ]);
    }

    #[Route('/categorie', name: 'app_category')]
    public function categorie( CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginatorInterface ): Response
    {   
        $categories = $paginatorInterface->paginate(
            $categoryRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/users', name: 'app_users')]
    public function users( UserRepository $userRepository, Request $request, PaginatorInterface $paginatorInterface ): Response
    {   
        $users = $paginatorInterface->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/article/delete/{id}', name:'app_article_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Article $article, Request $request, ArticleRepository $articleRepository): RedirectResponse
    {
        $tokenCsrf = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete-article-'. $article->getId(), $tokenCsrf)) {
            $articleRepository->remove($article, true);
            $this->addFlash('success', 'La catégorie à bien été supprimée');
            $success = true;
        }

        return $this->redirectToRoute('app_admin', [
            'success' => $success
        ]);
    }
}
