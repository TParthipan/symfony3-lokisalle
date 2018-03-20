<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Salle;
use AppBundle\Form\SalleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/salle")
 */
class SalleController extends Controller {

    /**
     * @Route("/")
     */
    public function listAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $salles = $em->getRepository('AppBundle:Salle')->findAll();

        $salle = new Salle;
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($salle);
            $em->flush();
            $this->addFlash('success', 'Votre salle a été ajouté');
            return $this->redirectToRoute('app_admin_salle_list');
        }
        return $this->render('admin/salle/list.html.twig', [
                    'salles' => $salles, 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", defaults={"id":null})
     * @param int $id
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $originalPhoto = null;
        if (is_null($id)) {
            $salle = new Salle;
        } else {//modif
            $salle = $em->find('AppBundle:Salle', $id);
            if (is_null($salle)) {
                return $this->redirectToRoute('app_admin_salle_edit');
            }

            if (!is_null($salle->getPhoto())) {
                $originalPhoto = $salle->getPhoto();
                $photoPath = $this->getParameter('upload_dir') . '/' . $salle->getPhoto();
                $salle->setPhoto(new File($photoPath));
            }
        }

        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        //si le formulaire a été envoyer
        if ($form->isSubmitted()) {
            //si il n'y a pas d'erreurs de validation du formulaire
            if ($form->isValid()) {
                /** @var UploadedFile */
                $photo = $salle->getPhoto();
                if (!is_null($photo)) {
                    //nom du fichier que l'on va enregistrer
                    $filename = uniqid() . '.' . $photo->guessExtension();
                    //equivalent move_uploaded_file()
                    $photo->move(
                            // repertoire de destination
                            $this->getParameter('upload_dir'), $filename
                    );
                    $salle->setPhoto($filename);
                } else {
                    //getData() sur une checkbox = true si cochée, false sinon
                    if ($form->has('remove_photo') && $form->get('remove_photo')->getData()) {
                        $salle->setPhoto(null);
                        unlink($this->getParameter('upload_dir') . '/' . $originalPhoto);
                    } else {

                        $salle->setPhoto($originalPhoto);
                    }
                }
                $em->persist($salle); //prepare l'enregistrement
                $em->flush(); //fait l'enregistrement en bdd

                $msg = 'L\'annonce de la salle a été enregistrée';
                $this->addFlash('success', $msg); //ajoute msg flash;
                return $this->redirectToRoute('app_admin_salle_list'); // redirige vers list
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('admin/salle/edit.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $salle = $em->find('AppBundle:Salle', $id);
        if (is_null($salle)) {
            return $this->redirectToRoute('app_admin_salle_list');
        }
        //prépare,la suppression de la catégorie
        $em->remove($salle);
        //suppression
        $em->flush();
        $this->addFlash('warning', 'L\'annonce de la salle a été supprimée'); //ajoute msg flash;
        return $this->redirectToRoute('app_admin_salle_list'); // redirige vers list
    }

}
