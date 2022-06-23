<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository,PaginatorInterface $paginatorInterface, Request $request): Response
    {
        

        $articles = $paginatorInterface->paginate(
            $articleRepository->findAll(),
            $request->query->getInt('page',1),6
        );

        $id = $request->query->get("id");
        
        if($id){
            $idcat = $categoryRepository->find($id);
            if(!$idcat){
                $this->addFlash('error'," L'id $id n'existe pas");
                return $this->render('bundles/TwigBundle/Exception/error404.html.twig');

               }
               else{
                
                $articles = $paginatorInterface->paginate(
                    $articleRepository->findBy(['category' => $id]),
                    $request->query->getInt('page',1),6
                );
               }
        }
    

        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    #[Route('/article/new', name: 'newArticle')]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article;
        $form = $this->createForm(ArticleFormType::class, $article,[
            'validation_groups' => ['new'],
        ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $article->setOwner($this->getUser());
            $articleRepository->add($article, true);

            $this->addFlash('success', 'Votre article à bien été enregistré !');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('home/newArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/article/edit/{id}', name: 'editArticle', requirements: ['id' => '\d+'])]
    public function update(article $article, Request $request, articleRepository $articleRepository): Response
    {

        $form = $this->createForm(articleFormType::class, $article);
        $form->handleRequest($request);
       
       
        if ($form->isSubmitted() && $form->isValid()) {
          
            $articleRepository->add($article, true);

            $this->addFlash('success', 'Le article :' . $article->gettitle() . 'mis a jour !');
            
            return $this->redirectToRoute('app_account');
        }

        return $this->render('home/newarticle.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    // #[IsGranted('ROLE_USER')]
    #[Route('/article/delete/{id}', name: 'deleteArticle', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(article $article, articleRepository $articleRepository, Request $request): RedirectResponse
    {
        $tokenCsrf = $request->request->get('token');
        if ($this->isCsrfTokenValid('deletearticle-' . $article->getId(), $tokenCsrf)) {
            $articleRepository->remove($article, true);
            $this->addFlash('success', 'L\'article : ' . $article->gettitle() . ' supprimer!');
        }
        return $this->redirectToRoute('app_home');
    }

    #[Route('/article/{id}', name: 'detailArticle', requirements: ['id' => '\d+'])]
    public function detail(article $article): Response
    {

        return $this->render('home/detail.html.twig', [
            'article' => $article,
        ]);
    }
}
