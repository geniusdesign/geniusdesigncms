<?php

namespace GeniusDesign\Components\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;

/**
 * GeniusDesign\Components\ContentBundle\Entity\Content
 *
 * @ORM\Table(name="genius_contents")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\ContentBundle\Repository\ContentRepository")
 */
class Content implements Translatable  {

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
     * @var string
     *
     * @ORM\Column(name="original_title", type="string", length=100)
     */
    private $original_title;
    
    /**
     * @var string $title_slug
     *
     * @ORM\Column(name="title_slug", type="string", length=100)
     * @Gedmo\Slug(fields={"original_title"})
     */
    private $title_slug;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $content;
    
    /**
     * @var string $autor
     *
     * @ORM\Column(name="autor", type="string", nullable=true)
     */
    private $autor;

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
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
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
     * Set original title
     *
     * @param string $original_title
     * @return Content
     */
    public function setOriginalTitle($title) {
        $this->original_title = $title;

        return $this;
    }

    /**
     * Get original title
     *
     * @return string 
     */
    public function getOriginalTitle() {
        return $this->original_title;
    }

    /**
     * Set title_slug
     *
     * @param string $titleSlug
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
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
     * Set content
     *
     * @param text $content
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
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
     * @param text $autor
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
     */
    public function setAutor($autor) {
        $this->autor = $autor;
        return $this;
    }

    /**
     * Get autor
     *
     * @return text 
     */
    public function getAutor() {
        return $this->autor;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
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
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
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
     * @return \GeniusDesign\Components\ContentBundle\Entity\Content
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