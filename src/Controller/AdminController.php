<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Form\CategoryFormType;
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


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(CategoryRepository $categoryRepository, ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $results = $articleRepository->findAll();

        $query = $request->query->get('query');
        if ($query) {
            $results = $articleRepository->findArticlesByName($query);
        }

        $articles = $paginatorInterface->paginate(
            $results,
            $request->query->getInt('page', 1),
            7
        );

        return $this->render('admin/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/admin/categorie', name: 'app_admin_category')]
    public function categorie(CategoryRepository $categoryRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $categories = $paginatorInterface->paginate(
            $categoryRepository->findAll(),
            $request->query->getInt('page', 1),
            1

        );

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    public function users(UserRepository $userRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $results = $userRepository->findAll();

        $query = $request->query->get('query');
        if ($query) {
            $results = $userRepository->findUserByName($query);
        }

        $users = $paginatorInterface->paginate(
            $results,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/article/delete/{id}', name: 'app_admin_article_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function deleteArticle(Article $article, Request $request, ArticleRepository $articleRepository): RedirectResponse
    {
        $tokenCsrf = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete-article-' . $article->getId(), $tokenCsrf)) {
            $articleRepository->remove($article, true);
            $this->addFlash('success', 'L\'Article à bien été supprimée');
            $success = true;
        }

        return $this->redirectToRoute('app_admin', [
            'success' => $success
        ]);
    }

    #[Route('/admin/categories/delete/{id}', name: 'app_admin_category_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function deleteCate(Category $category, Request $request, CategoryRepository $categoryRepository): RedirectResponse
    {

        $tokenCsrf = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-category-' . $category->getId(), $tokenCsrf)) {
            $categoryRepository->remove($category, true);
            $this->addFlash('success', 'La catégorie à bien été supprimée');
            $success = true;
        }

        return $this->redirectToRoute('app_admin', [
            'success' => $success
        ]);
    }

    #[Route('/admin/article/edit/{id}', name: 'app_admin_article_edit', requirements: ['id' => '\d+'])]
    public function editArticle($id = null, Article $article, Request $request, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        $idarticle = $articleRepository->find($id);



        if (!$idarticle) {
            $this->addFlash('error', " L'id $id n'existe pas");
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        } else {
            if ($form->isSubmitted() && $form->isValid()) {
                $articleRepository->add($article, true);
                $this->addFlash('success', 'L\'Article à bien été modifier');

                // Redirection vers une autre page
                return $this->redirectToRoute('app_admin');
            }
        }






        return $this->render('admin/editArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/category/edit/{id}', name: 'app_admin_category_edit', requirements: ['id' => '\d+'])]
    public function edit($id = null, Category $category, Request $request, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        $idcat = $categoryRepository->find($id);
        if (!$idcat) {
            $this->addFlash('error', " L'id $id n'existe pas");
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        } else {
            if ($form->isSubmitted() && $form->isValid()) {
                $categoryRepository->add($category, true);
                $this->addFlash('success', 'La catégorie à bien été modifier');

                // Redirection vers une autre page
                return $this->redirectToRoute('app_admin_category');
            }
        }


        return $this->render('admin/editCategories.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/users/edit/{id}/{role}', name: 'app_admin_user_role', methods: ['POST'])]
    public function roles(User $user, string $role, UserRepository $userRepository,): JsonResponse
    {

        $user->setRoles([$role]);
        $userRepository->add($user, true);

        return $this->json(['role' => $role]);
    }
}
