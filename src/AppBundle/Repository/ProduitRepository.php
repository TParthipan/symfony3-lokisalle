<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends EntityRepository {

    public function findProduit($data) {
        
        $qb = $this->createQueryBuilder('p');
        $qb->join('p.salle', 's');
         $qb ->where('p.etat= :etat')
                    ->setParameter('etat', 'libre');
        if (!is_null($data['categorie'])) {
            $qb
                    ->andWhere('s.categorie = :categorie')
                    ->setParameter('categorie', $data['categorie']);
        }
        if (!is_null($data['ville'])) {
            $qb
                    ->andWhere('s.ville = :ville')
                    ->setParameter('ville', $data['ville']);
        }

        if (!is_null($data['prix'])) {
            $qb
                    ->andWhere('p.prix >= :prix')
                    ->setParameter('prix', $data['prix']);
        }

        if (!is_null($data['capacite'])) {
            $qb
                    ->andWhere('s.capacite >= :capacite')
                    ->setParameter('capacite', $data['capacite']);
        }

        if (!is_null($data['dateA'])){
            $qb
                    ->andWhere('p.dateArrivee<= :dateA')
                    //->orWhere('p.dateArrivee>= :dateA')
                    ->setParameter('dateA', $data['dateA']);
        }
        if (!is_null($data['dateD'])) {
            $qb
                    //->andWhere('p.dateDepart<= :dateD')
                    ->andWhere('p.dateDepart>= :dateD')
                    ->setParameter('dateD', $data['dateD']);
        }

        $query = $qb->getQuery();
        //dump($query->getSQL());
        $membre = $query->getResult();
        //dump($membre);die;
        return $membre;
    }

}