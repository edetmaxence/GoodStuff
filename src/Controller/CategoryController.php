<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use ContainerDIPQXxB\getCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $category
        ]);

    }
    #[Route('/category/new', name: 'app_category_new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            $this->addFlash('success', 'La catégorie à bien été enregistrée');

            // Redirection vers une autre page
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/category/edit/{id}', name: 'app_category_edit', requirements:['id' => '\d+'])]
    public function edit(Category $category, Request $request, CategoryRepository $categoryRepository): Response 
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            $this->addFlash('success', 'La catégorie à bien été enregistrée');

            // Redirection vers une autre page
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView() 
        ]);
    }
    #[Route('/category/delete/{id}', name: 'app_category_delete', requirements:['id' => '\d+'], methods: ['POST'])]
    public function delete(Category $category, Request $request, CategoryRepository $categoryRepository): RedirectResponse 
    {
       $tokenCsrf = $request->request->get('token');
       
            // Protection par token pour éviter de se faire supprimer des catégories à distanse
       if ($this->isCsrfTokenValid('delete-category-'. $category->getId(), $tokenCsrf)) {

            $categoryRepository->remove($category, true);
            $this->addFlash('success', 'La catégorie à bien été supprimée'); 
       }

       return $this->redirectToRoute('app_category');
    }

}
