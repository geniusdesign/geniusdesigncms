<?php

namespace GeniusDesign\Components\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository class for content
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class ContentRepository extends EntityRepository {

    /**
     * Returns all content
     * 
     * @param [string $language = ''] The language title short
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getContents($language = '', $limit = null, $offset = null) {
        $criteria = array(
            'language' => $language,
            'deleted_at' => null
        );

        $orderBy = array('title' => 'asc');
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }
    
    /**
     * Returns content by given title slug
     * 
     * @param string $contentSlug The content slug
     * @param [string $language = ''] The language title short
     * @return array
     */
    public function getContentBySlug($contentSlug, $language = '') {
        $criteria = array(
            'title_slug' => $contentSlug,
            'language' => $language,
            'deleted_at' => null
        );

        return $this->findOneBy($criteria);
    }
}
