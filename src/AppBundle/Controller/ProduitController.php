<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Avis;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Membre;
use AppBundle\Entity\Produit;
use AppBundle\Form\AvisType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/produit")
 */
class ProduitController extends Controller {

    /**
     * @Route("/{id}")
     * @param int $id 
     * @param Produit $produit
     */
    public function displayAction(Request $request, Produit $produit) {
        $membre = new Membre();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
                ->add('submit', SubmitType::class, [
                    'label' => 'Réserver'
                ])
                ->getForm();
        $form->handleRequest($request);
        $membre = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $commande = new Commande();
            $commande->setMembre($membre);
            $produit->setEtat('reserver');
            $commande->setProduit($produit);
            $commande->getProduit($produit);
            $em->persist($commande);
            $em->flush();
            $this->addFlash('success', 'Vous avez réservé la salle' . ' ' . $produit->getSalle()->getTitre());
            return $this->redirectToRoute('app_default_index');
        }
        $avis = new Avis();
        $formc = $this->createForm(AvisType::class, $avis);
        $formc->handleRequest($request);
        if ($formc->isSubmitted()) {
            if ($formc->isValid()) {
                $avis
                        ->setSalle($produit->getSalle())
                        ->setMembre($this->getUser())
                ;
                $em->persist($avis); //prepare l'enregistrement
                $em->flush(); //fait l'enregistrement en bdd
                $msg = 'Le commentaire a été enregistrée';
                $this->addFlash('success', $msg); //ajoute msg flash;
                return $this->redirectToRoute('app_produit_display', ["id" => $produit->getId()]);
            }
        }
        return $this->render('produit/produit.html.twig', [
                    'produit' => $produit, 'form' => $form->createView(),'formc'=>$formc->createView()
        ]);
    }

}
