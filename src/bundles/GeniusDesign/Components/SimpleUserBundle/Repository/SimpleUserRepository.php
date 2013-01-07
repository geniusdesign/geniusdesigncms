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

}
