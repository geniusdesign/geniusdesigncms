<?php

namespace GeniusDesign\Components\NewsBundle\Repository;

use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * Repository class for news
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class NewsRepository extends MainRepository {

    /**
     * Returns all news
     * 
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getNews($limit = null, $offset = null) {
        $criteria = array(
            'deleted_at' => null
        );

        $orderBy = array('displayed_date' => 'desc');

        return $this->getEffect($criteria, $orderBy, $limit, $offset, true);
    }

    /**
     * Returns news by given title slug
     * 
     * @param string $newsSlug The news slug
     * @return array
     */
    public function getNewsBySlug($newsSlug) {
        $criteria = array(
            'title_slug' => $newsSlug,
            'deleted_at' => null
        );

        return $this->getEffect($criteria, array(), 0, 0, false);
    }

    /**
     * Returns news by given news id
     * 
     * @param string $newsId The news Id
     * @return array
     */
    public function getNewsById($newsId) {
        $criteria = array(
            'id' => $newsId,
            'deleted_at' => null
        );

        return $this->getEffect($criteria, array(), 0, 0, false);
    }

    /**
     * Deletes news by given news id
     * 
     * @param string $newsId The news id
     * @return array
     */
    public function deleteNewsById($newsId) {
        $result = false;
        $news = $this->getRow($newsId);

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
     * @return array
     */
    public function tooglePublishedBySlug($newsSlug) {
        $result = false;
        $news = $this->getNewsBySlug($newsSlug);

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