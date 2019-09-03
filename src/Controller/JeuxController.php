<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JeuxController extends AbstractController
{


    /**
     * @Route("/jeux/{id}", name="jeux")
     */
    public function jeux($id, JeuxRepository $jeuxRepository)
    {
        $jeu = $jeuxRepository->find($id);
        $jeux = $jeuxRepository->findAll();

        return $this->render('jeux/all_jeux.html.twig', [
            'jeu' => $jeu,
            'jeux' => $jeux
        ]);
    }

}