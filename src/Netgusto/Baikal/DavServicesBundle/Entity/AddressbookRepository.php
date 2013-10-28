<?php

namespace Netgusto\Baikal\DavServicesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AddressbookRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressbookRepository extends EntityRepository {

    public function countAll() {
        $qb = $this->createQueryBuilder('Addressbook');
        $qb->select('count(Addressbook.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findByUser(User $user) {
        $identityprincipal = $user->getIdentityPrincipal();

        if(!is_null($identityprincipal)) {
            return $this->findByPrincipaluri($identityprincipal->getUri());
        }

        return array();
    }
}
