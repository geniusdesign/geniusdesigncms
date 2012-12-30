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

    /**
     * Returns news by given title slug
     * 
     * @param string $newsSlug The news slug
     * @param [string $language = ''] The language title short
     * @return array
     */
    public function getNewsBySlug($newsSlug, $language = '') {
        $criteria = array(
            'title_slug' => $newsSlug,
            'language' => $language,
            'deleted_at' => null
        );

        return $this->findOneBy($criteria);
    }

    /**
     * Returns news by given news id
     * 
     * @param string $newsId The news Id
     * @param [string $language = ''] The language title short
     * @return array
     */
    public function getNewsById($newsId, $language = '') {
        $criteria = array(
            'id' => $newsId,
            'language' => $language,
            'deleted_at' => null
        );

        return $this->findOneBy($criteria);
    }

    /**
     * Deletes news by given news id
     * 
     * @param string $newsId The news id
     * @param [string $language = ''] The language title short
     * @return array
     */
    public function deleteNewsById($newsId, $language = '') {
        $result = false;
        $news = $this->getNewsById($newsId, $language);

        if (!empty($news)) {
            $manager = $this->getEntityManager();

            $manager->remove($news);
            $manager->flush();
            $result = true;
        }

        return $result;
    }

    /**
     * Toogle published news by given news slug
     * 
     * @param string $newsSlug The news slug
     * @param [string $language = ''] The language title short
     * @return array
     */
    public function tooglePublishedBySlug($newsSlug, $language = '') {
        $result = false;
        $news = $this->getNewsBySlug($newsSlug, $language);

        if (!empty($news)) {
            $manager = $this->getEntityManager();
            $published = $news->getPublished();

            if ($published) {
                $news->setPublished(false);
            } else {
                $news->setPublished(true);
            }

            $manager->persist($news);
            $manager->flush();
            $result = true;
        }

        return $result;
    }

}