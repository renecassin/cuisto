<?php

namespace AvekApeti\BackBundle\Repository;

/**
 * CommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandeRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOneByG($User_id,$id)
    {

        $query = $this->_em->createQueryBuilder($User_id,$id)
            ->select("c")
            ->from("AvekApetiBackBundle:Commande", "c")
            ->where('c.utilisateur = :User_id AND c.id = :id')
            ->setParameter('id',$id)
            ->setParameter('User_id',$User_id)
            ->getQuery();

        return $query->getSingleResult();

    }

    public function getOneByC($Chef_id,$id)
    {

        $query = $this->_em->createQueryBuilder($Chef_id,$id)
            ->select("c")
            ->from("AvekApetiBackBundle:Commande", "c")
            ->where('c.chef = :Chef_id AND c.id = :id')
            ->setParameter('id',$id)
            ->setParameter('Chef_id',$Chef_id)
            ->getQuery();


        return $query->getSingleResult();
    }
}
