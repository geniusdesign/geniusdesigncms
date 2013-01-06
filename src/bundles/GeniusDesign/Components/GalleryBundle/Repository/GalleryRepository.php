<?php

namespace GeniusDesign\Components\GalleryBundle\Repository;

use GeniusDesign\CommonBundle\Repository\MainRepository;

/**
 * Repository class for gallery
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class GalleryRepository extends MainRepository {

    /**
     * Returns all galleries
     * 
     * @param [integer $limit = null] Maximum amount of items
     * @param [integer $offset = null] The start position, offset
     * @return array
     */
    public function getGalleries($limit = null, $offset = null) {
        $criteria = array();
        $orderBy = array('created_at' => 'desc');

        return $this->getEffect($criteria, $orderBy, $limit, $offset, true);
    }
    
    /**
     * Returns gallery by given title slug
     * 
     * @param string $gallerySlug The gallery slug
     * @return Gallery
     */
    public function getGalleryBySlug($gallerySlug) {
        $criteria = array(
            'slug' => $gallerySlug,
        );

        return $this->getOneEffect($criteria);
    }
    
    /**
     * Returns gallery by given title slug
     * 
     * @param string $gallerySlug The gallery slug
     * @param [boolean $removeImagesAlso = true]
     * @return boolean
     */
    public function deleteGalleryBySlug($gallerySlug, $removeImagesAlso = true) {
        $result = false;
        $gallery = $this->getGalleryBySlug($gallerySlug);

        if (!empty($gallery)) {
            $manager = $this->getEntityManager();
            $images = $gallery->getImages();
            
            if(!empty($images) && $removeImagesAlso){
                foreach($images as $image){
                    $manager->remove($image);
                }
            }

            $manager->remove($gallery);
            $manager->flush();
            $result = true;
        }

        return $result;
    }
    
}