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
     * @Route("/admin", name="admin")
     */
    public function admin() {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/jeux" , name="admin_jeux", methods="GET|POST")
     */

    public function admin_jeux(JeuxRepository $jeuxRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $jeux = $jeuxRepository->findAll();
        return $this->render('admin/admin_jeux.html.twig', ["jeux" => $jeux]);

    }

    /**
     * @Route("/admin/jeu/insert" , name="jeux_form_insert")
     */

    public function jeuFormInsert(Request $request, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $jeu = new Jeux;
        /* Création d'un formulaire à partir d'un gabarit "JeuxType"*/
        $form = $this->createForm(JeuxType::class, $jeu);
        $formJeuView = $form->createView();

        if ($request->isMethod('post')) {
            /*On fait appel à la méthode "handleRequest" qui fait le lien entre les données rentrées et le formulaire*/
            $form->handleRequest($request);

            $imageFile = $form['photos']->getData();

            if ($imageFile) {
                /*Capture le nom de mon image et la stock dans la variable "$originalFilname" */
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
                // Met à jour l'image pour stocker le nouveau nom de l'image
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $jeu = $jeuxRepository->find($id);

        $entityManager->remove($jeu);
        $entityManager->flush();
        $this->addFlash('success','Jeu supprimé avec succès');

        return $this->redirectToRoute('admin_jeux');

    }



    /**
     * @Route("/admin/{id}/update", name="admin_jeu_modif")
     */
    public function jeuFormModif($id, Request $request, EntityManagerInterface $entityManager, JeuxRepository $jeuxRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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