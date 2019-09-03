<?php


namespace App\Controller;



use App\Entity\Personnages;
use App\Form\PersonnagesType;
use App\Repository\PersonnagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPersoController extends AbstractController
{
    /**
     * @Route("/admin/perso" , name="admin_perso")
     */
    public function admin_perso(PersonnagesRepository $personnagesRepository)
    {
        $persos = $personnagesRepository->findAll();
        return $this->render('admin/admin_perso.html.twig', ["persos" => $persos]);

    }

    /**
     * @Route("/admin/perso/form_insert" , name="perso_form_insert")
     */

    public function persoFormInsert(Request $request, EntityManagerInterface $entityManager)
    {

        $perso = new Personnages();

        $form = $this->createForm(PersonnagesType::class, $perso);
        $formPersoView = $form->createView();

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
                $perso->setPhotos($newFilename);
            }

            $entityManager->persist($perso);
            $entityManager->flush();
            $this->addFlash('success','Personnage crée avec succès');
            return $this->redirectToRoute('admin_perso');
        }

        return $this->render('admin/admin_perso_from.html.twig', [
            'formPersoView' => $formPersoView
        ]);
    }


    /**
     * @Route("/admin/perso/{id}/delete" , name="perso_delete")
     */

    public function persoDelete($id, PersonnagesRepository $personnagesRepository, EntityManagerInterface $entityManager)
    {
        $perso = $personnagesRepository->find($id);

        $entityManager->remove($perso);
        $entityManager->flush();
        $this->addFlash('success','Personnage supprimé avec succès');

        return $this->redirectToRoute('admin_perso');

    }


    /**
     * @Route("/admin/perso/{id}/form_modif", name="perso_form_modif")
     */
    public function jeuFormModif($id, Request $request, EntityManagerInterface $entityManager, PersonnagesRepository $personnagesRepository)
    {

        $perso = $personnagesRepository->find($id);

        $form = $this->createForm(PersonnagesType::class, $perso);
        $formPersoView = $form->createView();
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
                $entityManager->persist($perso);
                $entityManager->flush();
                $this->addFlash('success','Personnage édité avec succès');
                return $this->redirectToRoute('admin_perso');
            }
        }

        return $this->render('admin/admin_perso_from.html.twig', [

            'formPersoView' => $formPersoView
        ]);


    }
}