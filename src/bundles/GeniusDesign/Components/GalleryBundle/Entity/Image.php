<?php

namespace GeniusDesign\Components\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;

/**
 * Image
 *
 * @ORM\Table(name="genius_1_gallery_images")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\GalleryBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image implements Translatable {

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
     * @ORM\Column(name="title", type="string", length=100)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100)
     * @Gedmo\Slug(fields={"title"})
     * @Gedmo\Translatable
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="autor", type="string", length=255, nullable=true)
     */
    private $autor;

    /**
     * @var string
     *
     * @ORM\Column(name="image_file_name", type="string", length=255)
     */
    private $image_file_name;

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
     * Gallery
     *
     * @ORM\ManyToOne(targetEntity="GeniusDesign\Components\GalleryBundle\Entity\Gallery", inversedBy="images")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     * 
     * @var GeniusDesign\Components\GalleryBundle\Entity\Gallery
     */
    private $gallery;

    /**
     * @Assert\File(maxSize="6000000")
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    private $image;

    /**
     * Helper for uploading
     * @var \GeniusDesign\CommonBundle\Helper\UploadHelper
     */
    private $uploadHelper;

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
     * @return Image
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
     * Set slug
     *
     * @param string $slug
     * @return Image
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
     * Set autor
     *
     * @param string $autor
     * @return Image
     */
    public function setAutor($autor) {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor() {
        return $this->autor;
    }

    /**
     * Set image_file_name
     *
     * @param string $imageFileName
     * @return Image
     */
    public function setImageFileName($imageFileName) {
        $this->image_file_name = $imageFileName;

        return $this;
    }

    /**
     * Get image_file_name
     *
     * @return string 
     */
    public function getImageFileName() {
        return $this->image_file_name;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Image
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
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Image
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
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Image
     */
    public function setDeletedAt($deleted_at) {
        $this->deleted_at = $deleted_at;
        return $this;
    }

    /**
     * Set gallery
     *
     * @param \GeniusDesign\Components\GalleryBundle\Entity\Gallery $gallery
     * @return Image
     */
    public function setGallery($gallery) {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Gallery
     */
    public function getGallery() {
        return $this->gallery;
    }

    /**
     * Returns the file object
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Sets the uploaded image object
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $image The uploaded image
     * @return Image
     */
    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    /**
     * Returns helper for uploading
     * @return \GeniusDesign\CommonBundle\Helper\UploadHelper
     */
    public function getUploadHelper() {
        return $this->uploadHelper;
    }

    /**
     * Sets the helper
     * 
     * @param \GeniusDesign\CommonBundle\Helper\UploadHelper $uploadHelper The helper service / object
     * @return \GeniusDesign\Components\GalleryBundle\Entity\Image
     */
    public function setUploadHelper(\GeniusDesign\CommonBundle\Helper\UploadHelper $uploadHelper) {
        $this->uploadHelper = $uploadHelper;
        return $this;
    }

    /**
     * Handles the preUpdate event which occurs before the database update operations to entity data
     * @return void
     * 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function onPreUpload() {
        $image = $this->getImage();

        if ($image !== null) {
            $entityConfigName = 'genius_design_components_gallery';
            $dimensionsOk = true; //$this->getUploadHelper()->checkImageDimensions($entityClassName, $image, 'image');

            if ($dimensionsOk) {
                /*
                 * Removing old image / file
                 */
                $fileName = $this->getImageFileName();

                if (!empty($fileName)) {

                    $removed = $this->getUploadHelper()->removeFile($entityConfigName, $fileName, true, false);

                    if ($removed) {
                        $this->setImageFileName(null);
                    }
                }

                /*
                 * Setting future name for the new image / file
                 */
                $this->setFutureFileName();
            }
        }
    }

    /**
     * Handles the postUpdate event which occurs before the database update operations to entity data
     * @return void
     * 
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function onPostUpdate() {
        $image = $this->getImage();

        if ($image !== null) {
            $entityConfigName = 'genius_design_components_gallery';
            $fileName = $this->getImageFileName();
            $itsImage = true;

            $this->getUploadHelper()->upload($entityConfigName, $image, $fileName, $itsImage);
        }
    }

    /**
     * Sets proper name of file / image
     * @return void
     */
    private function setFutureFileName() {
        $name = $this->getImageFileName();

        if (empty($name)) {
            $originalFileName = $this->getImage()->getClientOriginalName();
            $helper = $this->getUploadHelper();

            $name = $helper->getUniqueFileName($originalFileName, $this->getId());
            $this->setImageFileName($name);
        }
    }

    /**
     * Sets localization code
     * 
     * @param string $language The language string, language code
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
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
