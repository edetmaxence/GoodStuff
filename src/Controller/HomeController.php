<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $categories = $categoryRepository->findAll();
        $articles= $articleRepository->findAll();           

        $id = $request->query->get("id");

        if ($id) {
            $articles = $articleRepository->findBy(['category' => $id]);
        }
        return $this->render('home/index.html.twig', [
            'articles'=>$articles,
            'categories' => $categories,
        ]);
    }

    #[Route('/article/new', name: 'newArticle')]
    // #[IsGranted('ROLE_USER')]
    public function add(Request $request,ArticleRepository $articleRepository): Response
    {
        $article = new Article;
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $articleRepository->add($article, true);

            $this->addFlash('success', 'Votre article à bien été enregistré !');

          
           
            return $this->redirectToRoute('app_home');
            
        }

        return $this->render('home/newArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/article/edit/{id}', name: 'editArticle', requirements:['id'=>'\d+'])]
    public function update(article $article, Request $request,articleRepository $articleRepository): Response
    {
        $form = $this->createForm(articleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article, true);
            
            $this->addFlash('success', 'Le article :'.$article->gettitle().'mis a jour !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/newarticle.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
    // #[IsGranted('ROLE_USER')]
    #[Route('/article/delete/{id}', name: 'deleteArticle', requirements:['id'=>'\d+'], methods: ['POST'])]
    public function delete(article $article,articleRepository $articleRepository, Request $request): RedirectResponse
     {
        $tokenCsrf = $request->request->get('token');
        if($this->isCsrfTokenValid('deletearticle-'.$article->getId(),$tokenCsrf ) ){
        $articleRepository ->remove($article,true);
        $this->addFlash('success', 'L\'article : '.$article->gettitle().' supprimer!');
        }
        return $this->redirectToRoute('app_home');
    }

    #[Route('/article/{id}', name: 'detailArticle', requirements:['id'=>'\d+'])]
    public function detail(article $article): Response
    {

        return $this->render('home/detail.html.twig', [
            'article'=> $article,
        ]);
    }
}
