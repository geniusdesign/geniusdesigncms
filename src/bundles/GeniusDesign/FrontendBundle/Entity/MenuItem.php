<?php

namespace GeniusDesign\FrontendBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * MenuItem
 *
 * @ORM\Table(name="genius_menu_frontend_menu_items")
 * @ORM\Entity(repositoryClass="GeniusDesign\FrontendBundle\Repository\MenuItemRepository")
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class MenuItem implements Translatable {

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
     * @ORM\Column(name="original_title", type="string", length=100)
     */
    private $original_title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100)
     * @Gedmo\Slug(fields={"original_title"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="viewname", type="string", length=100)
     */
    private $viewname;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_default", type="boolean")
     */
    private $is_default = false;

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
     * @return MenuItem
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
     * @return MenuItem
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
     * Set slug
     *
     * @param string $slug
     * @return MenuItem
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
     * Set viewname
     *
     * @param string $viewname
     * @return MenuItem
     */
    public function setViewname($viewname) {
        $this->viewname = $viewname;

        return $this;
    }

    /**
     * Get viewname
     *
     * @return string 
     */
    public function getViewname() {
        return $this->viewname;
    }

    /**
     * Set is_default
     *
     * @param boolean $value
     * @return MenuItem
     */
    public function setIsDefault($value) {
        $this->is_default = $value;

        return $this;
    }

    /**
     * Get is_default
     *
     * @return boolean 
     */
    public function getIsDefault() {
        return $this->is_default;
    }
    
    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return \GeniusDesign\FrontendBundle\Entity\MenuItem
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
     * @return \GeniusDesign\FrontendBundle\Entity\MenuItem
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
     * @return \GeniusDesign\FrontendBundle\Entity\MenuItem
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
