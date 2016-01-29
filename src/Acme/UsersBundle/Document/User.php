<?php

namespace Acme\UsersBundle\Document;

class User
{
    /**
     * @var Documents\Group
     */
    protected $groups = array();
    
    protected $name;

    protected $password;
    
    /**
     * @var MongoId $id
     */
    protected $id;
    
    
    
    
    /**
     * Set group
     *
     * @param \Acme\UsersBundle\Document\Group $group
     * @return User
     */
    public function setGroup(\Acme\UsersBundle\Document\Group $group)
    {
        if(!$this->groups->contains($group)){
            $this->groups->add($group);
        }
        return $this;
    }
    
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    

    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add group
     *
     * @param Documents\Group $group
     */
    public function addGroup(\Documents\Group $group)
    {
        $this->groups[] = $group;
    }

    /**
     * Remove group
     *
     * @param Documents\Group $group
     */
    public function removeGroup(\Documents\Group $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection $groups
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
