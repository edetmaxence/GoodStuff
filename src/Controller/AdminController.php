<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Form\CategoryFormType;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/admin/categorie', name: 'app_admin_category')]
    public function categorie(Category $category, CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginatorInterface ): Response
    {   
        $categories = $paginatorInterface->paginate(
            $categoryRepository->findAll(),
            $request->query->getInt('page', 1),
            8
        );

        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            $this->addFlash('success', 'La catégorie à bien été modifier');

            // Redirection vers une autre page
            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
            'form' => $form->createView() 
        ]);
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    public function users( UserRepository $userRepository, Request $request, PaginatorInterface $paginatorInterface ): Response
    {   
        $users = $paginatorInterface->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/article/delete/{id}', name:'app_admin_article_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function deleteArticle(Article $article, Request $request, ArticleRepository $articleRepository): RedirectResponse
    {
        $tokenCsrf = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete-article-'. $article->getId(), $tokenCsrf)) {
            $articleRepository->remove($article, true);
            $this->addFlash('success', 'L\'Article à bien été supprimée');
            $success = true;
        }

        return $this->redirectToRoute('app_admin', [
            'success' => $success
        ]);
    }

    #[Route('/admin/categories/delete/{id}', name:'app_admin_category_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function deleteCate(Category $category, Request $request, CategoryRepository $categoryRepository): RedirectResponse
    {   
        
        $tokenCsrf = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-category-'. $category->getId(), $tokenCsrf)) {
            $categoryRepository->remove($category, true);
            $this->addFlash('success', 'La catégorie à bien été supprimée');
            $success = true;
        }

        return $this->redirectToRoute('app_admin', [
            'success' => $success
        ]);
    }

    #[Route('/admin/article/edit/{id}', name:'app_admin_article_edit', requirements: ['id' => '\d+'])]
    public function editArticle(Article $article, Request $request, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article, true);
            $this->addFlash('success', 'L\'Article à bien été modifier');

            // Redirection vers une autre page
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/editArticle.html.twig', [
            'form' => $form->createView() 
        ]);
    }

    #[Route('/category/edit/{id}', name: 'app_admin_category_edit', requirements:['id' => '\d+'])]
    public function edit(Category $category, Request $request, CategoryRepository $categoryRepository): Response 
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            $this->addFlash('success', 'La catégorie à bien été modifier');

            // Redirection vers une autre page
            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('admin/editCategories.html.twig', [
            'form' => $form->createView() 
        ]);
    }

    #[Route('/admin/users/edit/{id}', name:'app_admin_user_edit', requirements: ['id' => '\d+'])]
    public function editUsers(User $user, Request $request, UserRepository $userRepository): Response
    {   
        $id = $request->get('id');
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            $this->addFlash('success', 'L\'utilisateur à bien été modifier');

            // Redirection vers une autre page
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/editUsers.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }

    #[Route('/admin/users/edit/{id}/{role}', name: 'app_admin_user_role', methods: ['POST'])]
    public function roles(User $user, string $role, UserRepository $userRepository, ): JsonResponse{
       
        $user->setRoles([$role]);
        $userRepository->add($user, true);

        return $this->json(['role' => $role]);
    }
}
