<?php


namespace App\Controller;


use App\Entity\Jeux;
use App\Form\JeuxType;
use App\Repository\JeuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminJeuxController extends AbstractController
{
    /**
     * @Route("/admin/jeux" , name="admin_jeux", methods="GET|POST")
     */


    public function admin_jeux(JeuxRepository $jeuxRepository)
    {
        $jeux = $jeuxRepository->findAll();
        return $this->render('admin/admin_jeux.html.twig', ["jeux" => $jeux]);

    }

    /**
     * @Route("/admin/jeu/insert" , name="jeux_form_insert")
     */

    public function jeuFormInsert(Request $request, EntityManagerInterface $entityManager)
    {

        $jeu = new Jeux;

        $form = $this->createForm(JeuxType::class, $jeu);
        $formJeuView = $form->createView();

        if ($request->isMethod('post')) {

            $form->handleRequest($request);
            $imageFile = $form['photos']->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Nécessaire pour inclure le nom du fichier en tant qu'URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // Déplace le fichier dans le dossier des images de la image
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                // Met à jour l'image pour stocker le nouveau nom de la image
                $jeu->setPhoto($newFilename);
            }

            $entityManager->persist($jeu);
            $entityManager->flush();
            $this->addFlash('success','Jeu crée avec succès');
            return $this->redirectToRoute('admin_jeux');
        }

        return $this->render('admin/admin_jeux_form.html.twig', [
            'formJeuView' => $formJeuView
        ]);
    }

    /**
     * @Route("/admin/jeu/{id}/delete" , name="jeu_delete")
     */

    public function jeuDelete($id, JeuxRepository $jeuxRepository, EntityManagerInterface $entityManager)
    {
        $jeu = $jeuxRepository->find($id);

        $entityManager->remove($jeu);
        $entityManager->flush();
        $this->addFlash('success','Jeu supprimé avec succès');

        //return new Response('suppression');

        return $this->redirectToRoute('admin_jeux');

    }



    /**
     * @Route("/admin/{id}/update", name="admin_jeu_modif")
     */
    public function jeuFormModif($id, Request $request, EntityManagerInterface $entityManager, JeuxRepository $jeuxRepository)
    {

        $jeu = $jeuxRepository->find($id);

        $form = $this->createForm(JeuxType::class, $jeu);
        $formJeuView = $form->createView();
        //si le mehode est POST
        //si le formulaire est envoyé
        if ($request->isMethod('post')) {
            //Le formulaire récupère les infos
            // de la requete
            $form->handleRequest($request);
            //on vérifie que le formulaire est valide
            if ($form->isValid()) {
                //on renregistre l'entité créée avec persist
                //et flush
                $entityManager->persist($jeu);
                $entityManager->flush();
                $this->addFlash('success','Jeu édité avec succès');
                return $this->redirectToRoute('admin_jeux');

            }
        }

        return $this->render('admin/admin_jeux_form.html.twig', [

            'formJeuView' => $formJeuView
        ]);

    }
}