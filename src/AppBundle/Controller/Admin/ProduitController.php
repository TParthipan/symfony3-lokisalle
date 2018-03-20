<?php
namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Produit;
use AppBundle\Form\ProduitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/produit")
 */
class ProduitController extends Controller {

    /**
     * @Route("/{id}", defaults={"id":null})
     * @param int $id
     * @param Request $request
     */
    public function registerAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id)) {
            $produit = new Produit();
        } else {//modif
            $produit = $em->find('AppBundle:Produit', $id);
        }
        if (is_null($produit)) {
            return $this->redirectToRoute('app_admin_produit_register');
        }
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success', 'Votre produit est créé');
            return $this->redirectToRoute('app_admin_produit_register');
        } else {
            // $this->addFlash('error', 'Le formulaire contient des erreurs');
        }
        $produits = $em->getRepository('AppBundle:Produit')->findAll();
        return $this->render('admin/produit/edit.html.twig', [
                    'form' => $form->createView(), 'produits' => $produits
        ]);
    }
/**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->find('AppBundle:Produit', $id);
        if (is_null($produit)) {
            return $this->redirectToRoute('app_admin_produit_register');
        }
        //prépare,la suppression de la catégorie
        $em->remove($produit);
        //suppression
        $em->flush();
        $this->addFlash('warning', 'Le produit a été supprimée'); //ajoute msg flash;
        return $this->redirectToRoute('app_admin_produit_register'); // redirige vers list
    }
}
