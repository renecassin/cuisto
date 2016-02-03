<?php

namespace AvekApeti\BackBundle\Repository;

/**
 * UtilisateurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\ResultSetMappingBuilder;


class PlatRepository extends \Doctrine\ORM\EntityRepository
{

    public function findOneIfChef($User_id,$id)
    {

        $query = $this->_em->createQueryBuilder($User_id,$id)
            ->select("p")
            ->from("AvekApetiBackBundle:Plat", "p")
            ->where('p.id = :id AND p.Utilisateur = :User_id AND p.supp != :supp')
            ->setParameter('User_id',$User_id)
            ->setParameter('id',$id)
            ->setParameter('supp','1')
            ->getQuery();

        return $query->getSingleResult();
    }

    public function findIfChef($User_id)
    {

        $query = $this->_em->createQueryBuilder($User_id)
            ->select("p")
            ->from("AvekApetiBackBundle:Plat", "p")
            ->where('p.Utilisateur = :User_id AND p.supp = :supp')
            ->setParameter('User_id',$User_id)
            ->setParameter('supp','0')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Récupération des plats en fonction de la longitude lattide et de la disponibilité (quantité et date)
     * @param $lat
     * @param $lng
     * @param int $page
     * @return mixed
     */
    public function findAllPlatWithGeoloc($lat, $lng, $page =1)
    {

        $box = $this->getBoundaries($lat, $lng, 4);

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata('AvekApetiBackBundle:Plat', 'p');
        $sql = 'SELECT p.*, c.lat, c.lng,
                ( 6371 * ACOS(COS( RADIANS(:latitude) ) * 
                    COS(RADIANS( c.lat ) ) * COS(RADIANS( c.lng ) - RADIANS(:longitude) ) +
                    SIN( RADIANS(:latitude) ) * SIN(RADIANS( c.lat ) ) )) AS distance,
                    TIMESTAMPDIFF(MINUTE, DATE_FORMAT(unableWhile, "1970-01-01 %H:%i:%s"), DATE_FORMAT(NOW(), "1970-01-01 %H:%i:%s")) AS diff_hour
                FROM plat p
                JOIN utilisateur u ON p.utilisateur_id = u.id
                JOIN chef c ON c.utilisateur_id = u.id
                WHERE p.supp = 0
                AND (c.lat BETWEEN :min_lat AND :max_lat) AND (c.lng BETWEEN :min_lng AND :max_lng)
                AND p.quantity > 0
                HAVING distance < 10 AND diff_hour > 0
                ORDER BY distance ASC
                ';
        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(':latitude', $lat);
        $query->setParameter(':longitude', $lng);
        $query->setParameter(':min_lat', $box['min_lat']);
        $query->setParameter(':max_lat', $box['max_lat']);
        $query->setParameter(':min_lng', $box['min_lng']);
        $query->setParameter(':max_lng', $box['max_lng']);

        return $query->getResult();
    }

    private static function getBoundaries($lat, $lng, $distance = 10, $earthRadius = 6371){
        $return = [];
        $cardinalCoords = ['north' => '0',
            'south' => '180',
            'east' => '90',
            'west' => '270'];

        $rLat = deg2rad($lat);
        $rLng = deg2rad($lng);
        $rAngDist = $distance/$earthRadius;

        foreach ($cardinalCoords as $name => $angle){
            $rAngle = deg2rad($angle);
            $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
            $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));

            $return[$name] = ['lat' => (float) rad2deg($rLatB), 
                'lng' => (float) rad2deg($rLonB)];
        }

        return ['min_lat'  => $return['south']['lat'],
            'max_lat' => $return['north']['lat'],
            'min_lng' => $return['west']['lng'],
            'max_lng' => $return['east']['lng']];
    }
}



// SELECT u.id, a.latitude, a.longitude, a.postal_code, a.city, p.name, p.profile_image, p.comuneat_score, 
// (IF((select 1 from favorite where owner_id = 0 and favorite_id = u.id ),1,0)) favorite, 
// (SELECT AVG( seller_score ) score FROM sale WHERE seller_id = u.id AND seller_score > 0) score, 
// (SELECT score FROM rating WHERE voted_id = u.id AND voter_id = 0) my_score, d.week_limit, d.dishes_week_limit, d.price, 
// (IFNULL((SELECT AVG( price ) FROM product WHERE seller_detail_id = d.id),0)) avg_price, 
// ( 6371 * ACOS(COS( RADIANS(48.8939119) ) * COS(RADIANS( a.latitude ) ) * COS(RADIANS( a.longitude ) - RADIANS(2.3540874999999915) ) + SIN( RADIANS(48.8939119) ) * SIN(RADIANS( a.latitude ) ) ) ) AS distance, 
// GROUP_CONCAT(ft.name SEPARATOR '-') food_types FROM user u LEFT JOIN seller_profile p ON u.id = p.user_id 
// LEFT JOIN address a ON a.id = p.address_id LEFT JOIN seller_detail d ON u.id = d.user_id 
// LEFT JOIN seller_food_type sft ON d.id = sft.seller_detail_id LEFT JOIN food_type ft ON ft.id = sft.food_type_id 
// WHERE u.is_active = 1 AND u.is_seller = 1 AND p.published = 1 AND u.is_deleted = 0 AND (d.price > 0 OR 
//     (SELECT COUNT(*) FROM product pr WHERE pr.seller_detail_id=d.id)>0) AND (a.latitude BETWEEN 48.857939035763 AND 48.929884764237) 
// AND (a.longitude BETWEEN 2.299372210192 AND 2.4088027898079) GROUP BY u.id HAVING distance < 10 ORDER BY distance ASC LIMIT 0,9



