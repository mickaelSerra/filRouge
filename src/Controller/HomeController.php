<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use App\Repository\JeuxRepository;
use App\Repository\PersonnagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    //Création de la route
    /**
     * @Route("/", name="index")
     */
    // "lienJeux" = méthode qui permet d'afficher tous les titres des jeux dans ma Navbar
    //je mets en paramètre le JeuxRepository car je vais avoir besoin d'afficher tous les titres de mes jeux
    public function lienJeux(JeuxRepository $jeuxRepository, PersonnagesRepository $personnagesRepository)
    {
        //findall permet de trouver toutes les données stockées dans ma BDD jeux
        $jeux = $jeuxRepository->findAll();
        $jeu = $jeuxRepository->findAll();
        $perso = $personnagesRepository->findAll();
        //on apelle un fichier twig avec en paramètre le nom du fichier twig
        return $this->render('base/header.html.twig',
            [
                //en second paramètre un tableau qui contient les variables envoyées au fichier twig
                //Il ne reste plus qu'à les appeler dans le fichier Twig
                'jeux' => $jeux,
                'jeu' => $jeu,
                'perso' => $perso
            ]);
    }



}