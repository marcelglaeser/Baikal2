<?php

namespace Netgusto\Baikal\DavServicesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {

    public function countAll() {
        $qb = $this->createQueryBuilder('User');
        $qb->select('count(User.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}