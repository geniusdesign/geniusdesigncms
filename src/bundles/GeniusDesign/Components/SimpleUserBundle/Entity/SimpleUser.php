<?php

namespace GeniusDesign\Components\SimpleUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser
 *
 * @ORM\Table(name="genius_2_simple_users")
 * @ORM\Entity(repositoryClass="GeniusDesign\Components\SimpleUserBundle\Repository\SimpleUserRepository")
 */
class SimpleUser implements AdvancedUserInterface, \Serializable {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $first_name
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $first_name;

    /**
     * @var string $last_name
     *
     * @ORM\Column(name="last_name", type="string", length=80, nullable=true)
     */
    private $last_name;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=200)
     */
    private $email;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=32)
     */
    private $password;

    /**
     * @var string $note
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var string $avatar
     *
     * @ORM\Column(name="avatar", type="string", length=50, nullable=true)
     */
    private $avatar;

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
     * Gallery
     *
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="simple_users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * 
     * @var SimpleUser
     */
    protected $role;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->first_name = $firstName;
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->last_name = $lastName;
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set note
     *
     * @param string $note
     */
    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar() {
        return $this->avatar;
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
     * @return \GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser
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
     * Set role
     *
     * @param Role $role
     */
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    /**
     * Get role.
     *
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }

    /*
     * Implements UserInterface
     */

    public function getRoles() {
        return array($this->role);
    }

    /**
     * Implements UserInterface
     * @param UserInterface $admin 
     */
    public function equals(UserInterface $admin) {
        
    }

    /**
     * Implements UserInterface
     */
    public function eraseCredentials() {
        
    }

    /**
     * Implements UserInterface
     */
    public function getSalt() {
        return 'b832a827b47f1c6e3f73977bc3752b6d';
    }

    /**
     * Implements UserInterface
     */
    public function getUsername() {
        /*
         * This method should return a value that is used to retrieve / find / identify user.
         * This value is used to get user after login form submit and it's value from "username" input / field.
         */
        return $this->getEmail();
    }

    /**
     * Extra method to validate the account status
     * 
     * Implements AdvancedUserInterface interface
     * @return boolean
     */
    public function isAccountNonExpired() {
        return true;
    }

    /**
     * Extra method to validate the account status
     * 
     * Implements AdvancedUserInterface interface
     * @return boolean
     */
    public function isAccountNonLocked() {
        return true;
    }

    /**
     * Extra method to validate the account status
     * 
     * Implements AdvancedUserInterface interface
     * @return boolean
     */
    public function isCredentialsNonExpired() {
        return true;
    }

    /**
     * Extra method to validate the account status
     * 
     * Implements AdvancedUserInterface interface
     * @return boolean
     */
    public function isEnabled() {
        return $this->deleted_at === null;
    }

    /**
     * Returns string representation of object
     * @return string
     * 
     * @see implements \Serializable
     */
    public function serialize() {
        return serialize(
                        array(
                            $this->id,
                            $this->first_name,
                            $this->last_name,
                            $this->email,
                            $this->password,
                            $this->note,
                            $this->avatar,
                            $this->created_at,
                            $this->updated_at,
                            $this->deleted_at
                        )
        );
    }

    /**
     * Unserializes the original value
     * 
     * @param string $serialized The string representation of the object
     * @return \GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser
     * 
     * @see implements \Serializable
     */
    public function unserialize($serialized) {
        list(
                $this->id,
                $this->first_name,
                $this->last_name,
                $this->email,
                $this->password,
                $this->note,
                $this->avatar,
                $this->created_at,
                $this->updated_at,
                $this->deleted_at
                ) = unserialize($serialized);

        return $this;
    }

}