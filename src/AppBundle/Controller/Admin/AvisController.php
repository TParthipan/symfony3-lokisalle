<?php


namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Avis;
use AppBundle\Entity\Salle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/avis")
 */
class AvisController extends Controller{
    /**
     * @Route("/produit/{id}")
     */
    public function listAction(Request $request, Salle $salle) {
        $em = $this->getDoctrine()->getManager();
        $avis = $em->find('AppBundle:Avis', $salle->getId());
        return $this->render('admin/avis/avis.html.twig', [
                    'salle' => $salle,
                    'comments' => $avis
        ]);
    }

    /**
     * @Route("/delete/{id}")
     * 
     */
    public function deleteAction(Avis $avis) {
        $em = $this->getDoctrine()->getManager();
        $articleId=$avis->getSalle()->getId();
        $em->remove($avis);
        $em->flush();
        $this->addFlash('success', 'Le commentaire a été supprimée'); //ajoute msg flash;*}
        return $this->redirectToRoute('app_admin_avis_list',["id"=>$articleId]); // redirige vers list
    }
}
