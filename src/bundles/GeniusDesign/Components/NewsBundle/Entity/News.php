<?php

namespace GeniusDesign\Components\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;

/**
 * GeniusDesign\Components\NewsBundle\Entity\News
 *
 * @ORM\Table(name="genius_news")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\NewsBundle\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class News implements Translatable {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=100)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var string $title_slug
     *
     * @ORM\Column(name="title_slug", type="string", length=100)
     * @Gedmo\Slug(fields={"title"})
     * @Gedmo\Translatable
     */
    private $title_slug;

    /**
     * @var text $entrance
     *
     * @ORM\Column(name="entrance", type="text")
     * @Gedmo\Translatable
     */
    private $entrance;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $content;

    /**
     * @var text $autor
     *
     * @ORM\Column(name="autor", type="string", nullable=true)
     */
    private $autor;

    /**
     * @var string $displayed_date
     *
     * @ORM\Column(name="displayed_date", type="datetime", nullable=true)
     */
    private $displayed_date;

    /**
     * @var string $image_file_name
     * @ORM\Column(name="image_file_name", type="string", length=70, nullable=true)
     */
    private $image_file_name;

    /**
     * @var boolean $published
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

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
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
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
     * Set title_slug
     *
     * @param string $titleSlug
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setTitleSlug($titleSlug) {
        $this->title_slug = $titleSlug;
        return $this;
    }

    /**
     * Get title_slug
     *
     * @return string 
     */
    public function getTitleSlug() {
        return $this->title_slug;
    }

    /**
     * Set entrance
     *
     * @param text $entrance
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setEntrance($entrance) {
        $this->entrance = $entrance;
        return $this;
    }

    /**
     * Get entrance
     *
     * @return text 
     */
    public function getEntrance() {
        return $this->entrance;
    }

    /**
     * Set content
     *
     * @param text $content
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set autor
     *
     * @param string $autor
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
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
     * Set displayed date
     *
     * @param datetime $date
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setDisplayedDate($date) {
        $this->displayed_date = $date;
        return $this;
    }

    /**
     * Get displayed date
     *
     * @return datetime 
     */
    public function getDisplayedDate() {
        return $this->displayed_date;
    }

    /**
     * Sets name of the image (name of file)
     * 
     * @param string $imageFileName Name of the image (name of file)
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setImageFileName($imageFileName) {
        $this->image_file_name = $imageFileName;
        return $this;
    }

    /**
     * Returns name of the image (name of file)
     * @return string
     */
    public function getImageFileName() {
        return $this->image_file_name;
    }

    /**
     * Set published
     *
     * @param $value The boolean value
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setPublished($value) {
        $this->published = $value;
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
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
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
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
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setDeletedAt($deleted_at) {
        $this->deleted_at = $deleted_at;
        return $this;
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
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
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
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
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
            //$entityClassName = __CLASS__;
            $entityConfigName = 'genius_design_components_news';
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
            $entityConfigName = 'genius_design_components_news';
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
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
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