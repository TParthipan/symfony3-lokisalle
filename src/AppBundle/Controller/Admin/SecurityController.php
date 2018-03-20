<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Membre;
use AppBundle\Form\MembreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Description of SecurityController
 *
 * @author stagiaire
 */
class SecurityController extends Controller {

    /**
     * @Route("/inscription/{id}", defaults={"id":null})
     * @param int $id
     * @param Request $request
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id) {
        $em = $this->getDoctrine()->getManager();
        $membres = $em->getRepository('AppBundle:Membre')->findAll();

        if (is_null($id)) {
            $membre = new Membre;
                $form = $this->createForm(MembreType::class, $membre, [
            //default: les validation qui n'appartiennent à aucun groupe
            //registration: la validation pour plainPassword
            'validation_groups' => ['Default', 'registration']
        ]);
        } else {//modif
            $membre = $em->find('AppBundle:Membre', $id);
            if (is_null($membre)) {
                return $this->redirectToRoute('app_admin_security_register');
            }
        
        $form = $this->createForm(MembreType::class, $membre, [
            //default: les validation qui n'appartiennent à aucun groupe
            //registration: la validation pour plainPassword
            'validation_groups' => ['Default']
        ]);}
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($membre->getMdpclair())) {
                $password = $passwordEncoder->encodePassword($membre, $membre->getMdpclair());
                 $membre->setMdp($password);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();
            $this->addFlash('success', 'Votre compte est créé');
            return $this->redirectToRoute('app_admin_security_register');
        } else {
            // $this->addFlash('error', 'Le formulaire contient des erreurs');
        }

        return $this->render('admin/membre/edit.html.twig', [
                    'form' => $form->createView(), 'membres' => $membres
        ]);
    }
/**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $membre = $em->find('AppBundle:Membre', $id);
        if (is_null($membre)) {
            return $this->redirectToRoute('app_admin_security_register');
        }
        //prépare,la suppression de la catégorie
        $em->remove($membre);
        //suppression
        $em->flush();
        $this->addFlash('warning', 'Le membre a été supprimée'); //ajoute msg flash;
        return $this->redirectToRoute('app_admin_security_register'); // redirige vers list
    }
}
