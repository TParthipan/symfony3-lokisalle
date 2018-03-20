<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Commande;
use AppBundle\Form\CommandeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/commande")
 */
class CommandeController extends Controller {

    /**
     * @Route("/{id}", defaults={"id":null})
     * @param int $id
     * @param Request $request
     */
    public function registerAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id)) {
            $commande = new Commande();
        } else {//modif
            $commande = $em->find('AppBundle:Commande', $id);
        }
        if (is_null($commande)) {
            return $this->redirectToRoute('app_admin_commande_register');
        }
        $commandes = $em->getRepository('AppBundle:Commande')->findAll();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commande->getProduit()->setEtat('reserver');
            $em->persist($commande); //prepare l'enregistrement
            $em->flush();
            
            return $this->redirectToRoute('app_admin_commande_register');
             
        }
       
        return $this->render('admin/commande/edit.html.twig', [
                    'form' => $form->createView(), 'commandes' => $commandes
        ]);
    }

    /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->find('AppBundle:Commande', $id);
        if (is_null($commande)) {
            return $this->redirectToRoute('app_admin_commande_register');
        }
        $commande->getProduit()->setEtat('libre');
        $em->remove($commande);
        //suppression
        $em->flush();
        $this->addFlash('warning', 'Le produit a été supprimée'); //ajoute msg flash;
        return $this->redirectToRoute('app_admin_commande_register'); // redirige vers list
    }

}
