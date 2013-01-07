<?php

namespace GeniusDesign\Components\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Gallery
 *
 * @ORM\Table(name="genius_2_galleries")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\GalleryBundle\Repository\GalleryRepository")
 */
class Gallery implements Translatable {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="original_title", type="string", length=255)
     */
    private $original_title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"original_title"})
     */
    private $slug;

    /**
     * Images
     *
     * @ORM\OneToMany(targetEntity="GeniusDesign\Components\GalleryBundle\Entity\Image", mappedBy="gallery")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    /**
     * @var datetime $deleted_at
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Gallery
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set original_title
     *
     * @param string $originalTitle
     * @return Gallery
     */
    public function setOriginalTitle($originalTitle) {
        $this->original_title = $originalTitle;

        return $this;
    }

    /**
     * Get original_title
     *
     * @return string 
     */
    public function getOriginalTitle() {
        return $this->original_title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Gallery
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set images
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $images The images
     * @return Gallery
     */
    public function setImages($images) {
        $this->images = $images;

        return $this;
    }

    /**
     * Set images
     *
     * @param \GeniusDesign\Components\GalleryBundle\Entity\Image $image
     * @return Gallery
     */
    public function addImage(\GeniusDesign\Components\GalleryBundle\Entity\Image $image) {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Gallery
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Gallery
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Gallery
     */
    public function setUpdatedAt($updatedAt) {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * Get deleted_at
     *
     * @return datetime 
     */
    public function getDeletedAt() {
        return $this->deleted_at;
    }

    /**
     * Set deleted_at
     *
     * @param datetime $updatedAt
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Gallery
     */
    public function setDeletedAt($deleted_at) {
        $this->deleted_at = $deleted_at;
        return $this;
    }

    /**
     * Sets localization code
     * 
     * @param string $language The language string, language code
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Gallery
     */
    public function setTranslatableLocale($locale) {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Get localization code
     * @return string 
     */
    public function getTranslatableLocale() {
        return $this->locale;
    }

}
