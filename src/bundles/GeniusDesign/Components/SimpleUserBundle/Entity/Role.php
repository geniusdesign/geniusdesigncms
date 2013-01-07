<?php

namespace GeniusDesign\Components\SimpleUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * GeniusDesign\Components\SimpleUserBundle\Entity\Role
 *
 * @ORM\Table(name="genius_2_simple_user_roles")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\SimpleUserBundle\Repository\RoleRepository")
 */
class Role /*implements RoleInterface*/ {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="original_name", type="string", length=30)
     */
    private $original_name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"original_name"})
     */
    private $slug;

    /**
     * @var string $code_name
     *
     * @ORM\Column(name="code_name", type="string", length=20, unique=true)
     */
    private $code_name;

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
     * @var \DateTime $deleted_at
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\OneToMany(targetEntity="SimpleUser", mappedBy="role")
     */
    protected $simple_users;

    /**
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

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
     * Set name
     *
     * @param string $Name
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set original name
     *
     * @param string $originalName
     * @return Role
     */
    public function setOriginalName($originalName) {
        $this->original_name = $originalName;

        return $this;
    }

    /**
     * Get original name
     *
     * @return string 
     */
    public function getOriginalName() {
        return $this->original_name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Role
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
     * Get code name
     *
     * @return string
     */
    public function getCodeName() {
        return $this->code_name;
    }

    /**
     * Set code name
     *
     * @param string $codeName
     * @return Role
     */
    public function setCodeName($codeName) {
        $this->code_name = $codeName;
        return $this;
    }
    
    /**
     * Get code name.
     * Implements RoleInterface.
     *
     * @return string 
     */
    public function getRole() {
        return $this->code_name;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
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
     * Set deleted_at
     *
     * @param \DateTime $updatedAt
     * @return \GeniusDesign\Components\SimpleUserBundle\Entity\Role
     */
    public function setDeletedAt($deleted_at) {
        $this->deleted_at = $deleted_at;
        return $this;
    }

    /**
     * Get deleted_at
     *
     * @return \DateTime
     */
    public function getDeletedAt() {
        return $this->deleted_at;
    }
    
    /**
     * Add simple users
     *
     * @param ArrayCollection $users
     * @return Role
     */
    public function setSimpleUsers($users) {
        $this->simple_users = $users;
        return $this;
    }
    
    /**
     * Add simple user
     *
     * @param SimpleUser $user
     * @return Role
     */
    public function addSimpleUser($user) {
        $this->simple_users[] = $user;
        return $this;
    }

    /**
     * Get simple users
     *
     * @return ArrayCollection
     */
    public function getSimpleUsers() {
        return $this->simple_users;
    }

    /**
     * Set role's parent
     *
     * @param Role $parent The role's parent
     * @return \GeniusDesign\Components\SimpleUserBundle\Entity\Role
     */
    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get role's parent
     *
     * @return \GeniusDesign\Components\SimpleUserBundle\Entity\Role
     */
    public function getParent() {
        return $this->parent;
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