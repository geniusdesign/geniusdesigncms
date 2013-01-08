<?php

namespace GeniusDesign\Components\SimpleUserBundle\Repository;

use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * Repository class for simple users
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class SimpleUserRepository extends MainRepository {

    /**
     * Returns all users
     * 
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getSimpleUsers($limit = null, $offset = null) {
        $criteria = array();

        $orderBy = array('created_at' => 'desc');
        return $this->getEffect($criteria, $orderBy, $limit, $offset, true);
    }

    /**
     * Returns user by email
     * 
     * @param string $email
     * @return array
     */
    public function getUserByEmail($email) {
        $criteria = array(
            'email' => $email
        );

        return $this->getOneEffect($criteria);
    }

    /**
     * Deletes user by given user Id
     * 
     * @param integer $userId
     * @return array
     */
    public function deleteSimpleUserById($userId) {
        $result = false;
        $user = $this->getRow($userId);

        if (!empty($user)) {
            $manager = $this->getEntityManager();

            $manager->remove($user);
            $manager->flush();
            $result = true;
        }

        return $result;
    }

    /**
     * Returns user by given user id and role code name
     * 
     * @param integer $userId
     * @param string $roleCode
     * @return SimpleUser 
     */
    public function getUserByIdAndRole($userId, $roleCode) {
        $result = null;

        if ($userId > 0 && !empty($roleCode)) {
            $queryBuilder = $this->createQueryBuilder('u')
                    ->leftJoin('u.role', 'i', \Doctrine\ORM\Query\Expr\Join::WITH, 'i.deleted_at is null')
                    ->where('u.id = :userId')
                    ->andWhere('i.code_name = :roleCode')
                    ->setParameters(array('roleCode' => $roleCode, 'userId' => $userId));

            $query = $queryBuilder->getQuery();
            
            $result = $this->setTranslationHints($query)
                    ->getOneOrNullResult();
        }

        return $result;
    }

}
