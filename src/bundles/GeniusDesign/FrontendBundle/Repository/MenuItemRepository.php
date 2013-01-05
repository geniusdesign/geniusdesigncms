<?php

namespace GeniusDesign\FrontendBundle\Repository;

use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * MenuItemRepository
 *
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class MenuItemRepository extends MainRepository {

    /**
     * Returns menu item by given slug
     * 
     * @param string $slug The menu item slug
     * @return array
     */
    public function getMenuItemBySlug($slug) {
        $criteria = array(
            'slug' => $slug
        );

        return $this->getOneEffect($criteria);
    }

    /**
     * Returns menu item by given viewname
     * 
     * @param string $viewname The view name
     * @return array
     */
    public function getMenuItemByViewname($viewname) {
        $criteria = array(
            'viewname' => $viewname
        );

        return $this->getOneEffect($criteria);
    }
    
    /**
     * Returns default menu item
     * 
     * @return array
     */
    public function getDefaultMenuItem() {
        $criteria = array(
            'is_default' => true
        );

        return $this->getOneEffect($criteria);
    }
    
}
