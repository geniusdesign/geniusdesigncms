<?php

namespace GeniusDesign\Components\GalleryBundle\Repository;

use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * Repository class for gallery image
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class ImageRepository extends MainRepository {

    /**
     * Returns all images
     * 
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getImages($limit = null, $offset = null) {
        $criteria = array();
        $orderBy = array('displayed_date' => 'desc');

        return $this->getEffect($criteria, $orderBy, $limit, $offset, true);
    }

    /**
     * Deletes image by given image id
     * 
     * @param string $imageId The image id
     * @return array
     */
    public function deleteImageById($imageId) {
        $result = false;
        $image = $this->getRow($imageId);

        if (!empty($image)) {
            $manager = $this->getEntityManager();

            $manager->remove($image);
            $manager->flush();
            $result = true;
        }

        return $result;
    }

}