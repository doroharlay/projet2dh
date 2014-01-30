<?php

namespace Projet2\BackBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 */
class ProductRepository extends EntityRepository
{
    
    public function getProductsByType($id)
    {

        $query = $this->createQueryBuilder('a')
        // On joint sur l'attribut type pour rapatrier les données de la table type afin d'éviter les requêtes multiples à la BDD lors de l'affichage du nom des types dans les vues
        ->leftJoin('a.type', 'c')
        ->addSelect('c')
        ->where('a.type = :id')
        ->setParameter('id', $id)
        ->orderBy('a.creationDate', 'ASC')
        ->getQuery();
        
        return $query->getResult();

    }
    
    
}
