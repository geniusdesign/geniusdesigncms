<?php

namespace GeniusDesign\Components\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GeniusDesign\Components\NewsBundle\Entity\News
 *
 * @ORM\Table(name="genius_news")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\NewsBundle\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class News {

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
     */
    private $title;

    /**
     * @var string $title_slug
     *
     * @ORM\Column(name="title_slug", type="string", length=100)
     * @Gedmo\Slug(fields={"title"})
     */
    private $title_slug;

    /**
     * @var text $entrance
     *
     * @ORM\Column(name="entrance", type="text")
     */
    private $entrance;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

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
     * @var text $language
     * @ORM\Column(name="language", type="string", length=5)
     */
    private $language;

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
     * Sets localization code
     * 
     * @param string $language The language string, language code
     * @return \GeniusDesign\Components\NewsBundle\Entity\News
     */
    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }
    
    /**
     * Get localization code
     * @return string 
     */
    public function getLanguage() {
        return $this->language;
    }
}