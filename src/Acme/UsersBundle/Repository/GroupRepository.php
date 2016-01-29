<?php

namespace Acme\UsersBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * GroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupRepository extends DocumentRepository
{
    /**
     * return default user group
     * @return Group
     */
    public function getDefaultGroup()
    {
        return $this->createQueryBuilder()
            ->field('role')->equals('guest')
            ->getQuery()
            ->getSingleResult();
    }
    
    
}