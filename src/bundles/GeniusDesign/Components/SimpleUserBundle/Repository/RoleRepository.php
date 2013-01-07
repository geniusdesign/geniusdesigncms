<?php

namespace GeniusDesign\Components\SimpleUserBundle\Repository;

use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * Repository class for role
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class RoleRepository extends MainRepository {

    /**
     * Returns all roles
     * 
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getRoles($limit = null, $offset = null) {
        $criteria = array();
        $orderBy = array();
        return $this->getEffect($criteria, $orderBy, $limit, $offset, true);
    }

}
