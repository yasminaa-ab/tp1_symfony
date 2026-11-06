<?php

namespace App\Controller;
//ajout tp2
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticlesController extends AbstractController
{
    // Exercice 4.1 : Ajouter un article
   #[Route('/articles/nouveau', name: 'app_article_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $em): Response
{
    // Création d'un nouvel article
    $article = new Article();

    // Création du formulaire
    $form = $this->createForm(ArticleType::class, $article);

    // Traitement de la requête
    $form->handleRequest($request);

    // Vérification de la soumission et de la validité
    if ($form->isSubmitted() && $form->isValid()) {

        // Enregistrement dans la base de données
        $em->persist($article);
        $em->flush();

        // Message de confirmation
        $this->addFlash('success', 'Article créé avec succès !');

        // Redirection vers la liste des articles
        return $this->redirectToRoute('app_articles');
    }

    // Affichage du formulaire
    return $this->render('articles/nouveau.html.twig', [
        'formulaire' => $form,
    ]);
    }

    // Exercice 4.2 : Lire les articles depuis la base de données
    #[Route('/articles', name: 'app_articles')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    // Exercice 4.3 : Afficher un article par son ID
    #[Route('/articles/{id}', name: 'app_article_detail', requirements: ['id' => '\d+'])]
    public function detail(Article $article): Response
    {
        return $this->render('articles/detail.html.twig', [
            'article' => $article,
        ]);
    }
}