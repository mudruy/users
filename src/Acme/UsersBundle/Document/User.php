<?php

namespace Acme\UsersBundle\Document;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDBUnique(fields="name")
 */
class User implements UserInterface {

    /**
     * @MongoDB\Field(type="collection")
     * @Assert\NotBlank()
     */
    protected $roles;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $name;
    protected $password;

    /**
     * @var MongoId $id
     */
    protected $id;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * get roles
     * @return array
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * set roles
     * @param type $roles
     * @return self
     */
    public function setRoles($roles) {
        $this->roles = $roles;
        return $this;
    }

    /**
     * null for bcrypt
     * @return null
     */
    public function getSalt() {
        return null;
    }

    /**
     * get username for implement auth interface
     * @return string
     */
    public function getUsername() {
        return $this->getName();
    }

    /**
     * implement auth interface
     */
    public function eraseCredentials() {
        
    }

    /**
     * implement auth interface
     * @param UserInterface $user
     * @return boolean
     */
    public function isEqualTo(UserInterface $user) {
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * for form save - not work documentation
     * @param User $user
     */
    public function setUser($user) {
        
    }

    /**
     * for form save - not work documentation
     * @return self
     */
    public function getUser() {
        return $this;
    }

}
