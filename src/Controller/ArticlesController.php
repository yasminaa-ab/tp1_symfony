<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticlesController extends AbstractController
{
    // Créer un article
    #[Route('/articles/nouveau', name: 'app_article_nouveau')]
    public function nouveau(Request $request,EntityManagerInterface $em,CategorieRepository $categorieRepository
    ): Response {
        $article = new Article();
        // Bonus : présélectionner une catégorie
        $categorieId = $request->query->getInt('categorie');
        if ($categorieId > 0) {
            $categorie = $categorieRepository->find($categorieId);
            if ($categorie) {
                $article->setCategorie($categorie);
            }
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', 'Article créé avec succès !');
            return $this->redirectToRoute('app_articles');
        }
        return $this->render('articles/nouveau.html.twig', [
            'formulaire' => $form,
        ]);
    }

    // Lire les articles avec filtre par catégorie
   #[Route('/articles', name: 'app_articles')]
    public function index(
    Request $request,
    ArticleRepository $articleRepository,
    CategorieRepository $categorieRepository
    ): Response {
    $categorieParam = $request->query->get('categorie');
    $categorieId = ctype_digit((string) $categorieParam)
        ? (int) $categorieParam
        : 0;
    if ($categorieId > 0) {
        $articles = $articleRepository->findBy([
            'categorie' => $categorieId,
        ]);                                   
    } else {
        $articles = $articleRepository->findAll();
    }
    $categories = $categorieRepository->findAll();
    return $this->render('articles/index.html.twig', [
        'articles' => $articles,
        'categories' => $categories,
        'categorieSelectionnee' => $categorieId,
    ]);
}
    // Afficher un article
    #[Route('/articles/{id}', name: 'app_article_detail', requirements: ['id' => '\d+'])]
    public function detail(Article $article): Response {
        return $this->render('articles/detail.html.twig', [
            'article' => $article,
        ]);
    }

    // Modifier un article
    #[Route('/articles/{id}/modifier', name: 'app_article_modifier', requirements: ['id' => '\d+'])]
    public function modifier(Article $article,Request $request,EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Article modifié avec succès !');
            return $this->redirectToRoute('app_article_detail', [
                'id' => $article->getId(),
            ]);
        }
        return $this->render('articles/modifier.html.twig', [
            'formulaire' => $form,
            'article' => $article,
        ]);
    }

    // Supprimer un article
    #[Route('/articles/{id}/supprimer',name: 'app_article_supprimer',requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function supprimer(Article $article,Request $request,EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid(
            'supprimer_' . $article->getId(),
            $request->request->get('_token')
        )) {
            $em->remove($article);
            $em->flush();
            $this->addFlash('success', 'Article supprimé avec succès.');
        } else {
            $this->addFlash('danger', 'Token CSRF invalide. Suppression annulée.');
        }
        return $this->redirectToRoute('app_articles');
    }
}