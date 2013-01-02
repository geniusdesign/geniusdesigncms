<?php

namespace GeniusDesign\Components\LanguageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * The language
 * GeniusDesign\Components\LanguageBundle\Entity\Language
 *
 * @ORM\Table(name="genius_languages")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\LanguageBundle\Repository\LanguageRepository")
 */
class Language {

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
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="language_code", type="string", length=3)
     */
    private $language_code;

    /**
     * @var string
     *
     * @ORM\Column(name="language_lcid", type="string", length=7)
     */
    private $language_lcid;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_path", type="string", length=255)
     */
    private $flag_path;

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
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
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
     * Set language_code
     *
     * @param string $languageCode
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
     */
    public function setLanguageCode($languageCode) {
        $this->language_code = $languageCode;
        return $this;
    }

    /**
     * Get language_code
     *
     * @return string 
     */
    public function getLanguageCode() {
        return $this->language_code;
    }

    /**
     * Set language_lcid
     *
     * @param string $languageLcid
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
     */
    public function setLanguageLcid($languageLcid) {
        $this->language_lcid = $languageLcid;
        return $this;
    }

    /**
     * Get language_lcid
     *
     * @return string 
     */
    public function getLanguageLcid() {
        return $this->language_lcid;
    }

    /**
     * Set flag_path
     *
     * @param string $flagPath
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
     */
    public function setFlagPath($flagPath) {
        $this->flag_path = $flagPath;
        return $this;
    }

    /**
     * Get flag_path
     *
     * @return string 
     */
    public function getFlagPath() {
        return $this->flag_path;
    }

    /**
     * Set default
     *
     * @param boolean $default
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
     */
    public function setIsDefault($default) {
        $this->is_default = $default;
        return $this;
    }

    /**
     * Get default
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
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
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
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
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
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
     */
    public function setDeletedAt($deleted_at) {
        $this->deleted_at = $deleted_at;
        return $this;
    }

}
