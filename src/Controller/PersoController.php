<?php


namespace App\Controller;


use App\Repository\JeuxRepository;
use App\Repository\PersonnagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersoController extends AbstractController
{

    /**
     * @Route("/perso/{id}", name="perso")
     */
    public function perso($id, PersonnagesRepository $personnagesRepository, JeuxRepository $jeuxRepository)
    {
        $perso = $personnagesRepository->find($id);
        $personnages = $personnagesRepository->findAll();
        $jeu = $jeuxRepository->find($id);
        $jeux = $jeuxRepository->findAll();

        return $this->render('jeux/all_perso.html.twig', [
            'perso' => $perso,
            'personnages' => $personnages,
            'jeu' => $jeu,
            'jeux' => $jeux
        ]);
    }
}