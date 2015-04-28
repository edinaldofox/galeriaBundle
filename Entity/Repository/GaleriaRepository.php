<?php
/**
 * Created by PhpStorm.
 * User: edinaldo
 * Date: 31/03/15
 * Time: 23:15
 */

namespace GaleriaBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class GaleriaRepository extends EntityRepository
{

    /**
     * Pega as galerias ativas no sistema
     * @return array
     */
    public function getGaleriasAtivas()
    {

        $qb = $this->createQueryBuilder('g')
            ->where('g.isAtivo = :ativo')
            ->setParameter('ativo', true)
            ->getQuery()
            ->getResult();

        return $qb;
    }

}

