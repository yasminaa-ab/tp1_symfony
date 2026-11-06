<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TacheController extends AbstractController
{
    // 1. Liste des tâches
    #[Route('/taches', name: 'app_taches')]
    public function index(TacheRepository $tacheRepository): Response
    {
        $taches = $tacheRepository->findBy([], [
            'terminee' => 'ASC',
            'dateCreation' => 'DESC'
        ]);

        return $this->render('tache/index.html.twig', [
            'taches' => $taches,
        ]);
    }

    // 2. Ajouter une tâche
    #[Route('/taches/ajouter', name: 'app_tache_ajouter')]
    public function ajouter(EntityManagerInterface $em): Response
    {
        $tache = new Tache();

        $tache->setTitre('Apprendre Symfony');
        $tache->setDescription('Terminer le TP1 Symfony et comprendre Doctrine.');
        $tache->setDateCreation(new \DateTime());
        $tache->setTerminee(false);

        $em->persist($tache);
        $em->flush();

        return $this->redirectToRoute('app_taches');
    }

    // 3. Afficher le détail d'une tâche
    #[Route('/taches/{id}', name: 'app_tache_detail', requirements: ['id' => '\d+'])]
    public function detail(Tache $tache): Response
    {
        return $this->render('tache/detail.html.twig', [
            'tache' => $tache,
        ]);
    }

    // 4. Bonus : terminer une tâche
    #[Route('/taches/{id}/terminer', name: 'app_tache_terminer', requirements: ['id' => '\d+'])]
    public function terminer(Tache $tache, EntityManagerInterface $em): Response
    {
        $tache->setTerminee(true);

        $em->flush();

        return $this->redirectToRoute('app_taches');
    }
}