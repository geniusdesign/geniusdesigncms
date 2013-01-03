<?php

namespace GeniusDesign\Components\ContentBundle\Repository;

use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * Repository class for content
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class ContentRepository extends MainRepository {

    /**
     * Returns all content
     * 
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getContents($limit = null, $offset = null) {
        $criteria = array(
            'deleted_at' => null
        );

        $orderBy = array('title' => 'asc');
        return $this->getEffect($criteria, $orderBy, $limit, $offset, true);
    }
    
    /**
     * Returns content by given title slug
     * 
     * @param string $contentSlug The content slug
     * @return array
     */
    public function getContentBySlug($contentSlug) {
        $criteria = array(
            'title_slug' => $contentSlug,
            'deleted_at' => null
        );

        return $this->getEffect($criteria, array(), 0, 0, false);
    }
}
