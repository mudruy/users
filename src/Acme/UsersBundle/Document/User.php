<?php

namespace Acme\UsersBundle\Document;

class User
{
    
    /** @ReferenceMany(targetDocument="Group") */
    private $groups;
    
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $password;
    
    /**
     * @var MongoId $id
     */
    protected $id;
    
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function setGroup(\Acme\UsersBundle\Document\Group $group)
    {
        $this->groups[] = $group;
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

}