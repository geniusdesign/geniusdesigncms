<?php

namespace GeniusDesign\Components\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository class for news
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class NewsRepository extends EntityRepository {

    /**
     * Returns all news
     * 
     * @param [string $language = ''] The language title short
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getNews($language = '', $limit = null, $offset = null) {
        $criteria = array(
            'language' => $language,
            'deleted_at' => null
        );

        $orderBy = array('displayed_date' => 'desc');
        
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }
}